<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EditProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Models\Diary;
use App\Models\Role;
use App\Models\TokenReset;

class ProfileController extends Controller
{
    public function verify($code)
    {
        $user = User::where("confirmation_code",$code)->first();

        if(!$user)
        {
            return redirect()->route("login")->withErrors(["No encontramos tu código de confirmación"]);
        }   

        $user->validate=1;
        $user->confirmation_code=null;
        $user->save();

        return redirect()->route("login")->with(["message_info"=>"Tu email ha sido verificado exitosamente, ya puedes iniciar sesión"]);
    }

    public function getLogin()
    {
        $user = User::getCurrent();

        if($user)
        {
            return redirect()->route("dashboard");
        }

        return view("user.login");
    }

    public function postLogin()
    {
        $data = Input::only('email','password');

        $check_user=User::where("email",$data['email'])->first();

        if($check_user && !$check_user->validate)
        {
            return redirect()->back()->withErrors("Confirma tu correo electrónico para poder iniciar sesión");
        }

        if($check_user && !$check_user->status)
        {
            return redirect()->back()->withErrors("Tu cuenta ha sido desactivada");
        }

        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']], true))
    	{
            $user = User::getCurrent();
            $user->verifyRole();

            return redirect()->route("dashboard");
        }

        if(!$check_user)
        {
            return redirect()->back()->withErrors("El email que has introducido es incorrecto");
        }
        else
        {
            return redirect()->back()->withErrors("La contraseña que has introducido es incorrecta");
        }
    }

    public function getResetPassword()
    {
        $user = User::getCurrent();

        if($user)
        {
            return redirect()->route("dashboard");
        }

        return view("user.password_recover");
    }

    public function sendResetLinkEmail(Request $request)
    {
        $email=$request->get("email");

        $user=User::where("email",$email)->first();
        if($user)
        {
            $user_token = new TokenReset();
            $user_token->email=$user->email;
            $user_token->save();

            $resetLink=route("password_reset_token",["token"=>$user_token->token]);

            \Mail::send('emails.user_reset_password', ["user"=>$user,"resetLink"=>$resetLink], function($message) use($user)
            {
                $message->subject("Recuperar contraseña de ACU");
                $message->to($user->email,$user->first_name);
            });

        }
        else
        {
            return redirect()->back()->withErrors("El email ingresado no se encuentra registrado");
        }

        return redirect()->route("login")->with(["message_info"=>"Te hemos enviado un correo electrónico para que recuperes tu contraseña"]);
    }

    public function getResetPasswordToken($token)
    {
        $user = User::getCurrent();

        if($user)
        {
            return redirect()->route("dashboard");
        }

        $token=TokenReset::where("token",$token)->first();
        
        if(!$token)
        {
            return redirect()->route("login")->withErrors(["El token ha expirado"]);
        }

        return view("user.password_change",["token"=>$token->token]);
    }

    public function resetPassword(Request $request)
    {
        $token=$request->get("token");
        $password=$request->get("password");

        if(!$password || strlen($password)<5)
        {
            return redirect()->back()->withErrors(["La contraseña debe tener al menos 5 caracteres"]);
        }

        $token=TokenReset::where("token",$token)->first();

        if(!$token)
        {
            return redirect()->route("login")->withErrors(["El token ha expirado"]);
        }

        $user=User::where("email",$token->email)->first();
        if(!$user)
        {
            return redirect()->route("login")->withErrors(["El token ha expirado"]);
        }

        User::where("id",$user->id)->update(["password"=>Hash::make($password)]);
        TokenReset::where("token",$token->token)->delete();
        return redirect()->route("login")->with(["message_info"=>"La contraseña se ha cambiado exitosamente"]);
    }

    public function getProfile()
    {
        return view("user.edit");
    }

    public function saveProfile(EditProfileRequest $request)
    {
        $user=User::getCurrent();
        
        $data=$request->only(["first_name","last_name","identity_card","phone_number","email"]);
        $password=$request->get("password");

        if($password && !empty($password))
        {
            $confirm_password=$request->get("confirm_password");

            if($password!=$confirm_password)
            {
                return redirect()->back()->withErrors(["Las contraseñas no coinciden"]);
            }

            if(strlen($password)<5)
            {
                return redirect()->back()->withErrors(["La contraseña debe tener al menos 5 caracteres"]);
            }

            User::where("id",$user->id)->update(["password"=>Hash::make($password)]);
        }

        $check_user=User::where("identity_card",$data["identity_card"])->first();
        if($check_user && $check_user->id!=$user->id)
        {
            return redirect()->back()->withErrors(["Ya existe un usuario con esa cédula de identidad"]);
        }

        $check_user=User::where("email",$data["email"])->first();
        if($check_user && $check_user->id!=$user->id)
        {
            return redirect()->back()->withErrors(["Ya existe un usuario con ese correo electrónico"]);
        }

        User::where("id",$user->id)->update($data);
        
        return redirect()->route("profile")->with(["message_info"=>"La información de su perfil ha sido actualizada"]);
    }

    public function getDashboard()
    {
        $user = User::getCurrent();
        $rol=$user->getCurrentRol();

        if($rol)
        {
            if($rol->name=="admin")
            {
                return redirect()->route("admin_dashboard");
            }

            if($rol->name=="presidente")
            {
                return redirect()->route("presidente_dashboard");
            }

            if($rol->name=="consejero")
            {
                 return redirect()->route("consejero_dashboard");
            }

            if($rol->name=="secretaria")
            {
                return redirect()->route("secretaria_dashboard");
            }

            if($rol->name=="adjunto")
            {
                return redirect()->route("adjunto_dashboard");
            }
        }
    }

    public function changeRol($rol)
    {
        $user = User::getCurrent();
        
        if($user->hasRole($rol))
        {
            $rol=Role::where("name",$rol)->first();
            session(['current_rol' => $rol->id]);
        }

        return redirect()->route("dashboard")->with(["message_info"=>"Se ha cambiado su rol"]);
    }

    public function getPresidentDashboard()
    {
        $date = new \DateTime();
        $date->modify('first day of this month');

        $new_date = new \DateTime();
        $new_date->modify('first day of this month')->add(new \DateInterval("P1M"));

        $diaries=Diary::orderBy("event_date","asc")->where("event_date",">=",$date->format("Y-m-d"))->where("event_date","<",$new_date->format("Y-m-d"))->get();

        $calendar=[];
        foreach($diaries as $key => $diary) 
        {
            $calendar[]=[\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d") => $diary->id];
        }

        return view("main.presidente_dashboard",["diaries"=>$diaries,"calendar"=>$calendar]);
    }

    public function getSecretariaDashboard()
    {
        $date = new \DateTime();
        $date->modify('first day of this month');

        $new_date = new \DateTime();
        $new_date->modify('first day of this month')->add(new \DateInterval("P1M"));

        $diaries=Diary::orderBy("event_date","asc")->where("event_date",">=",$date->format("Y-m-d"))->where("event_date","<",$new_date->format("Y-m-d"))->get();

        $calendar=[];
        foreach($diaries as $key => $diary) 
        {
            $calendar[]=[\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d") => $diary->id];
        }

        return view("main.secretaria_dashboard",["diaries"=>$diaries,"calendar"=>$calendar]);
    }

    public function getConsejeroDashboard()
    {
        $date = new \DateTime();
        $date->modify('first day of this month');

        $new_date = new \DateTime();
        $new_date->modify('first day of this month')->add(new \DateInterval("P1M"));

        $diaries=Diary::orderBy("event_date","asc")->where("event_date",">=",$date->format("Y-m-d"))->where("event_date","<",$new_date->format("Y-m-d"))->get();

        $calendar=[];
        foreach($diaries as $key => $diary) 
        {
            $calendar[]=[\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d") => $diary->id];
        }

        return view("main.consejero_dashboard",["diaries"=>$diaries,"calendar"=>$calendar]);
    }

    public function getAdjuntoDashboard()
    {
        $date = new \DateTime();
        $date->modify('first day of this month');

        $new_date = new \DateTime();
        $new_date->modify('first day of this month')->add(new \DateInterval("P1M"));

        $diaries=Diary::orderBy("event_date","asc")->where("event_date",">=",$date->format("Y-m-d"))->where("event_date","<",$new_date->format("Y-m-d"))->get();

        $calendar=[];
        foreach($diaries as $key => $diary) 
        {
            $calendar[]=[\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d") => $diary->id];
        }

        return view("main.adjunto_dashboard",["diaries"=>$diaries,"calendar"=>$calendar]);
    }
}
