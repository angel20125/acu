<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\Council;
use App\Models\Role;

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
            $rol=$user->roles->first();
            $council=$user->councils->first();

            if($rol->name!="admin")
            {
                $users_list[]=[$user->first_name." ".$user->last_name,$user->identity_card,$user->email,$user->phone_number,$rol->display_name,$council->name,'<a href="'.route("admin_users_edit",["user_id"=>$user->id]).'"><i data-toggle="tooltip" data-placement="bottom" title="Editar" class="fa fa-edit" aria-hidden="true"></i></a> <a href="'.route("admin_users_trash",["user_id"=>$user->id]).'"><i data-toggle="tooltip" data-placement="bottom" title="Eliminar" class="fa fa-trash" aria-hidden="true"></i></a>'];
            }
        }

        return response()->json(['data' => $users_list]);
    }

    public function getCreate()
    {
    	$councils=Council::all();

        if(count($councils)==0)
        {
            return redirect()->route("admin_councils_create")->withErrors(["Primero debes registrar un consejo como mínimo, para poder registrar un usuario"]);
        }

    	$roles=Role::all();
        return view("admin.user.create",["councils"=>$councils,"roles"=>$roles]);
    }

    public function create(CreateUserRequest $request)
    {
    	$council_id=$request->get("council_id");
    	$rol=$request->get("rol");

    	$council=Council::where("id",$council_id)->first();

    	if($council)
    	{
    		$members=$council->members;
    		foreach ($members as $member) 
    		{
    			if($member->hasRole("presidente") && $rol=="presidente" && $member->pivot->end_date==null) 
    			{
    				return redirect()->back()->withErrors(["El ".$council->name." ya tiene asignado un presidente"]);
    			}

    			if($member->hasRole("secretaria") && $rol=="secretaria" && $member->pivot->end_date==null) 
    			{
    				return redirect()->back()->withErrors(["El presidente del ".$council->name." ya tiene asignada una secretaria"]);
    			}

    			if($member->hasRole("adjunto") && $rol=="adjunto" && $member->pivot->end_date==null) 
    			{
    				return redirect()->back()->withErrors(["El ".$council->name." ya tiene asignado un adjunto"]);
    			}
    		}
    	}
        else
        {
            return redirect()->back()->withErrors(["Primero debes registrar un consejo como mínimo, para poder registrar un usuario"]);
        }

        $data=($request->only(["identity_card","first_name","last_name","phone_number","email"]));
        $data["password"]="12345";

        $user=User::create($data);

        $user->attachRole(Role::where("name",$rol)->first());

        $user->councils()->attach($council_id,["start_date"=>gmdate("d-m-Y")]);

        $rol=$user->roles->first();

        \Mail::send('emails.user_welcome', ["user"=>$user,"rol"=>$rol,"council"=>$council], function($message) use($user)
        {
            $message->subject("Bienvenido a ACU");
            $message->to($user->email,$user->first_name);
        });

        return redirect()->route("admin_users_edit",["user_id"=>$user->id])->with(["message_info"=>"Se ha registrado el usuario"]);
    }

    public function getEdit($user_id)
    {
        $edit_user=User::where("id",$user_id)->first();
        $roles=Role::all();

        $currentCouncil=$edit_user->councils->first(); 

        return view("admin.user.edit",["edit_user"=>$edit_user,"roles"=>$roles,"currentCouncil"=>$currentCouncil]); 
    }

    public function update(UpdateUserRequest $request)
    {
        $user_id=$request->get("user_id");
        $edit_user=User::where("id",$user_id)->first();

        $council_id=$request->get("council_id");
        $rol=$request->get("rol");

        $council=Council::where("id",$council_id)->first();

        if($council)
        {
            $members=$council->members;
            foreach ($members as $member) 
            {
                if($member->hasRole("presidente") && $rol=="presidente" && $member->pivot->end_date==null && $member->id!=$edit_user->id) 
                {
                    return redirect()->back()->withErrors(["El ".$council->name." ya tiene asignado un presidente"]);
                }

                if($member->hasRole("secretaria") && $rol=="secretaria" && $member->pivot->end_date==null && $member->id!=$edit_user->id) 
                {
                    return redirect()->back()->withErrors(["El presidente del ".$council->name." ya tiene asignada una secretaria"]);
                }

                if($member->hasRole("adjunto") && $rol=="adjunto" && $member->pivot->end_date==null && $member->id!=$edit_user->id) 
                {
                    return redirect()->back()->withErrors(["El ".$council->name." ya tiene asignado un adjunto"]);
                }
            }
        }

        $edit_user->detachRoles($edit_user->roles);
        $edit_user->attachRole(Role::where("name",$rol)->first());

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

        if($data["status"]==0) 
        {
            $edit_user->councils()->updateExistingPivot($council_id,["end_date"=>gmdate("d-m-Y")]);
        }
        else
        {
            $edit_user->councils()->updateExistingPivot($council_id,["start_date"=>gmdate("d-m-Y"),"end_date"=>null]);
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

        User::where("id",$user_id)->delete();

        return redirect()->route("admin_users")->with(["message_info"=>"Se ha eliminado el usuario"]);
    }
}
