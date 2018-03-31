<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\Role;

class UsersController extends Controller
{
    public function getIndex()
    {
        return view("council.list_users");
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
                if($user->positionBoss) 
                {
                    $roles="Secretaria de ".$user->positionBoss->name;
                }
            }

            if($councils=="") 
            {
                $councils="NA";
            }

            $position=$user->position->name;

            if($user->hasRole("secretaria"))
            {
                $position="NA";
            }

            if(!$user->hasRole("admin"))
            {
                $users_list[]=[$user->last_name." ".$user->first_name,$user->identity_card,$user->email,$user->phone_number,$position,$councils,$roles];
            }
        }

        return response()->json(['data' => $users_list]);
    }
}
