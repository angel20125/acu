<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Models\TokenReset;

class ProfileController extends Controller
{
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

        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']], true))
    	{
            $user = User::getCurrent();
            $user->verifyRole();

            if($user->status==0)
            {
                return redirect()->route("logout");
            }

            return redirect()->route("dashboard");
        }

        return redirect()->back()->withErrors("Datos incorrectos, verifique por favor");
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

        $limitTime=\DateTime::createFromFormat("Y-m-d H:i:s",gmdate("Y-m-d H:i:s"))->sub(new \DateInterval("PT1H"));
        $token=TokenReset::where("token",$token)->where("created_at",">",$limitTime->format("Y-m-d H:i:s"))->first();
        
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

        $limitTime=\DateTime::createFromFormat("Y-m-d H:i:s",gmdate("Y-m-d H:i:s"))->sub(new \DateInterval("PT1H"));
        $token=TokenReset::where("token",$token)->where("created_at",">",$limitTime->format("Y-m-d H:i:s"))->first();


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
                return "Aquí va el dashboard del presidente";
            }

            if($rol->name=="consejero")
            {
                return "Aquí va el dashboard del consejero";
            }

            if($rol->name=="secretaria")
            {
                return "Aquí va el dashboard del secretaria";
            }

            if($rol->name=="adjunto")
            {
                return "Aquí va el dashboard del adjunto";
            }
        }
    }
}
