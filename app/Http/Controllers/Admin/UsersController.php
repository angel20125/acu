<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSecretaryRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\Council;
use App\Models\Position;
use App\Models\Role;
use App\Models\Transaction;

class UsersController extends Controller
{
    public function getIndex()
    {
        return view("admin.user.list");
    }

    public function getList()
    {
        $users=User::get();

        $users_list=[];
        foreach($users as $user)
        {
            $roles="";
            $councils="";
            foreach($user->councils as $council)
            {
                $roles.=Role::where("id",$council->pivot->role_id)->first()->display_name."<br>";
                $councils.=$council->name."<br>";
            }

            if($roles=="") 
            {
                $roles="Secretaria";
            }

            if($councils=="") 
            {
                $councils="NA";
            }

            if(!$user->hasRole("admin"))
            {
                $users_list[]=[$user->last_name." ".$user->first_name,$user->identity_card,$user->email,$user->phone_number,$roles,$councils,'<a href="'.route("admin_users_edit",["user_id"=>$user->id]).'"><i data-toggle="tooltip" data-placement="bottom" title="Editar" class="fa fa-edit" aria-hidden="true"></i></a> <a href="'.route("admin_users_trash",["user_id"=>$user->id]).'"><i data-toggle="tooltip" data-placement="bottom" title="Eliminar" class="fa fa-trash" aria-hidden="true"></i></a>'];
            }
        }

        return response()->json(['data' => $users_list]);
    }

    public function getCreateSecretary()
    {
        $positions=Position::orderBy("name","asc")->where("name","<>","Administrador")->where("name","<>","Secretary")->get();

        if(count($positions)==0)
        {
            return redirect()->route("admin_positions_create")->withErrors(["Primero debes registrar un cargo como mínimo, para poder registrar una secretaria"]);
        }

        return view("admin.user.create_secretary",["positions"=>$positions]);
    }

    public function createSecretary(CreateSecretaryRequest $request)
    {
        $data=($request->only(["identity_card","first_name","last_name","phone_number","email","position_boss_id"]));
        $data["position_id"]=Position::where("name","Secretary")->first()->id;
        $data["password"]="12345";
        $data["confirmation_code"]=str_random(25);

        $user=User::create($data);

        $user->attachRole(Role::where("name","secretaria")->first());

        \Mail::send('emails.user_confirmation', ["user"=>$user,"confirmation_code"=>$data["confirmation_code"]], function($message) use($user)
        {
            $message->subject("Bienvenido a ACU");
            $message->to($user->email,$user->first_name);
        });

        return redirect()->route("admin_users")->with(["message_info"=>"Se ha registrado la secretaria exitosamente"]);
    }

    public function getCreate()
    {
        $positions=Position::orderBy("name","asc")->where("name","<>","Administrador")->where("name","<>","Secretary")->get();
    	$councils=Council::orderBy("name","asc")->get();

        if(count($positions)==0)
        {
            return redirect()->route("admin_positions_create")->withErrors(["Primero debes registrar un cargo como mínimo, para poder registrar un usuario"]);
        }

        if(count($councils)==0)
        {
            return redirect()->route("admin_councils_create")->withErrors(["Primero debes registrar un consejo como mínimo, para poder registrar un usuario"]);
        }

    	$roles=Role::orderBy("name","asc")->get();
        return view("admin.user.create",["positions"=>$positions,"councils"=>$councils,"roles"=>$roles]);
    }

    public function create(CreateUserRequest $request)
    {
        $last_councils=$request->get("council_id");
        $councils=array_unique($last_councils);

        if(count($last_councils)!=count($councils)) 
        {
            return redirect()->back()->withErrors(["Un usuario no puede puede tener dos cargos dentro de un mismo consejo"]);
        }

        $last_roles=$request->get("roles");
        $roles=array_unique($last_roles);
        
        $councils_errors=[];
        $count_errors_councils=0;

        foreach($councils as $key => $council)
        {
            $council=Council::where("id",$council)->first();
            $users=$council->users;

            foreach($users as $user) 
            {
                if($user->hasRole("presidente") && $last_roles[$key]=="presidente" && $council->president && $council->president->id==$user->id) 
                {
                    $councils_errors[$count_errors_councils]=["El ".$council->name." ya tiene asignado un presidente"];
                    $count_errors_councils++;
                }
                
                if($user->hasRole("adjunto") && $last_roles[$key]=="adjunto" && $council->adjunto && $council->adjunto->id==$user->id) 
                {
                    $councils_errors[$count_errors_councils]=["El ".$council->name." ya tiene asignado un presidente"];
                    $count_errors_councils++;
                }  
            }
        }

        if(!empty($councils_errors)) 
        {
            return redirect()->back()->withErrors($councils_errors); 
        }

        $data=($request->only(["identity_card","first_name","last_name","phone_number","email","position_id"]));
        $data["password"]="12345";
        $data["confirmation_code"]=str_random(25);

        $user=User::create($data);

        foreach($councils as $key => $council)
        {
            $rol=Role::where("name",$last_roles[$key])->first();

            $user->councils()->attach($council,["role_id"=>$rol->id]);
            Transaction::create(["type"=>"create_user_".$rol->name,"user_id"=>$user->id,"affected_id"=>$council,"start_date"=>gmdate("Y-m-d")]);

            if($last_roles[$key]=="presidente") 
            {
                Council::where("id",$council)->update(["president_id"=>$user->id]);
            }

            if($last_roles[$key]=="adjunto") 
            {
                Council::where("id",$council)->update(["adjunto_id"=>$user->id]);
            }

        }

        foreach($roles as $rol)
        {
            $user->attachRole(Role::where("name",$rol)->first());
        }

        \Mail::send('emails.user_confirmation', ["user"=>$user,"confirmation_code"=>$data["confirmation_code"]], function($message) use($user)
        {
            $message->subject("Bienvenido a ACU");
            $message->to($user->email,$user->first_name);
        });

        return redirect()->route("admin_users")->with(["message_info"=>"Se ha registrado el usuario exitosamente"]);
    }

    public function getEdit($user_id)
    {
        $edit_user=User::where("id",$user_id)->first();
        $positions=Position::orderBy("name","asc")->where("name","<>","Administrador")->where("name","<>","Secretary")->get();
        $councils=Council::orderBy("name","asc")->get();
        $roles=Role::orderBy("name","asc")->get();

        return view("admin.user.edit",["edit_user"=>$edit_user,"positions"=>$positions,"councils"=>$councils,"roles"=>$roles]); 
    }

    public function update(UpdateUserRequest $request)
    {
        $user_id=$request->get("user_id");
        $edit_user=User::where("id",$user_id)->first();

        if($edit_user->hasRole("secretaria"))
        {
            $data=($request->only(["identity_card","first_name","last_name","phone_number","email","status"]));

            $check_user=User::where("identity_card",$data["identity_card"])->first();
            if($check_user && $check_user->id!=$edit_user->id)
            {
                return redirect()->back()->withErrors(["Ya existe un usuario con esa cédula de identidad"]);
            }

            $check_user=User::where("email",$data["email"])->first();
            if($check_user && $check_user->id!=$edit_user->id)
            {
                return redirect()->back()->withErrors(["Ya existe un usuario con ese correo electrónico"]);
            }

            User::where("id",$user_id)->update($data);

            return redirect()->route("admin_users_edit",["user_id"=>$user_id])->with(["message_info"=>"Se ha actualizado el usuario"]); 
        }

        $last_councils=$request->get("council_id");

        if(!isset($last_councils)) 
        {
            return redirect()->back()->withErrors(["Un usuario debe pertenecer como mínimo a un consejo y tener un rol dentro del sistema"]);
        }

        $councils=array_unique($last_councils);

        if(count($last_councils)!=count($councils)) 
        {
            return redirect()->back()->withErrors(["Un usuario no puede puede tener dos cargos dentro de un mismo consejo"]);
        }

        $last_roles=$request->get("roles");
        $roles=array_unique($last_roles);
        
        $councils_errors=[];
        $count_errors_councils=0;

        foreach($councils as $key => $council)
        {
            $council=Council::where("id",$council)->first();
            $users=$council->users;

            foreach($users as $user) 
            {
                if($user->hasRole("presidente") && $last_roles[$key]=="presidente" && $council->president_id!=$edit_user->id) 
                {
                    $councils_errors[$count_errors_councils]=["El ".$council->name." ya tiene asignado el cargo de presidente"];
                    $count_errors_councils++;
                }
                
                if($user->hasRole("adjunto") && $last_roles[$key]=="adjunto" && $council->adjunto_id!=$edit_user->id) 
                {
                    $councils_errors[$count_errors_councils]=["El ".$council->name." ya tiene asignado el cargo de adjunto"];
                    $count_errors_councils++;
                }  
            }
        }

        if(!empty($councils_errors)) 
        {
            return redirect()->back()->withErrors($councils_errors); 
        }

        $councils_finals=[];
        $councils_new=[];

        $roles_finals=[];
        $roles_new=[];

        foreach($edit_user->councils as $council)
        {
            $councils_finals[]=$council->id;
            $roles_finals[]=$council->pivot->role_id;

            $edit_user->councils()->detach($council->id);
        }

        foreach($councils as $key => $council)
        {
            $rol=Role::where("name",$last_roles[$key])->first();

            $edit_user->councils()->attach($council,["role_id"=>$rol->id]);
            
            $councils_new[]=$council;
            $roles_new[]=$rol->id;

            $transaction=Transaction::where("type","create_user_".$rol->name)->where("user_id",$edit_user->id)->where("affected_id",$council)->where("end_date",null)->first();

            if(!$transaction)
            {
                Transaction::create(["type"=>"create_user_".$rol->name,"user_id"=>$edit_user->id,"affected_id"=>$council,"start_date"=>gmdate("Y-m-d")]);
            }

            if($last_roles[$key]=="presidente") 
            {
                Council::where("id",$council)->update(["president_id"=>$edit_user->id]);
            }

            if($last_roles[$key]=="adjunto") 
            {
                Council::where("id",$council)->update(["adjunto_id"=>$edit_user->id]);
            }
        }

        foreach($councils_finals as $key => $council)
        {
            if(array_search($council, $councils_new)===false)
            {
                Transaction::where("user_id",$edit_user->id)->where("affected_id",$council)->update(["end_date"=>gmdate("Y-m-d")]);
            }
            else
            {
                $rol=Role::where("id",$roles_finals[$key])->first();

                $transaction=Transaction::where("type","create_user_".$rol->name)->where("user_id",$edit_user->id)->where("affected_id",$council)->where("end_date",null)->first();

                $council_user=$edit_user->councils()->where("id",$council)->first();

                if($transaction && $council_user->pivot->role_id!=$rol->id)
                {
                    Transaction::where("id",$transaction->id)->update(["end_date" => gmdate("Y-m-d")]);
                }
            }
        }

        $edit_user->detachRoles($edit_user->roles);

        foreach($roles as $rol)
        {
            $edit_user->attachRole(Role::where("name",$rol)->first());
        }

        $data=($request->only(["identity_card","first_name","last_name","phone_number","email","status"]));

        $check_user=User::where("identity_card",$data["identity_card"])->first();
        if($check_user && $check_user->id!=$edit_user->id)
        {
            return redirect()->back()->withErrors(["Ya existe un usuario con esa cédula de identidad"]);
        }

        $check_user=User::where("email",$data["email"])->first();
        if($check_user && $check_user->id!=$edit_user->id)
        {
            return redirect()->back()->withErrors(["Ya existe un usuario con ese correo electrónico"]);
        }

        User::where("id",$user_id)->update($data);

        return redirect()->route("admin_users_edit",["user_id"=>$user_id])->with(["message_info"=>"Se ha actualizado el usuario"]);
    }

    public function getTrash($user_id)
    {
        $edit_user=User::where("id",$user_id)->first();

        return view("admin.user.trash",["edit_user"=>$edit_user]);
    }

    public function delete(Request $request)
    {
        $user_id=$request->get("user_id");

        try 
        {
            User::where("id",$user_id)->delete();
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return redirect()->back()->withErrors(["No puede eliminar un usuario del cual dependen funcionalidades del sistema"]);
        }
        

        return redirect()->route("admin_users")->with(["message_info"=>"Se ha eliminado el usuario"]);
    }
}
