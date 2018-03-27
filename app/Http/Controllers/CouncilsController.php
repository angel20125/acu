<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Council;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouncilsController extends Controller
{
    public function getIndex()
    {
        return view("council.list");
    }

    public function getList()
    {
        $councils=Council::get();

        $councils_list=[];
        foreach($councils as $council)
        {
            $councils_list[]=[$council->name,$council->president==null?"NA":$council->president->last_name." ".$council->president->first_name,$council->adjunto==null?"NA":$council->adjunto->last_name." ".$council->adjunto->first_name,'<a href="'.route("get_council",["council_id"=>$council->id]).'"><i class="fa fa-eye" aria-hidden="true"></i></a>'];
        }

        return response()->json(['data' => $councils_list]);
    }

    public function getCouncil($council_id)
    {
        $council=Council::where("id",$council_id)->first();

        return view("council.show",["council"=>$council]);
    }

    public function getListMembers($council_id)
    {
        $council=Council::where("id",$council_id)->first();

      	$users=$council->users;

        $users_list=[];
        foreach($users as $user)
        {
            $roles="";
            foreach($user->councils as $council)
            {
            	if($council->id==$council_id) 
            	{
	                $roles.=Role::where("id",$council->pivot->role_id)->first()->display_name;
            	}
            }

            if(!$user->hasRole("admin"))
            {
                $users_list[]=[$user->last_name." ".$user->first_name,$user->identity_card,$user->email,$user->phone_number,$roles];
            }
        }

        return response()->json(['data' => $users_list]);
    }
}
