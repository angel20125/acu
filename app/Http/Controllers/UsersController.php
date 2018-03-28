<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

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
                $roles="Secretaria";
            }

            if($councils=="")
            {
                $councils="NA";
            }

            if(!$user->hasRole("admin"))
            {
                $users_list[]=[$user->last_name." ".$user->first_name,$user->identity_card,$user->email,$user->phone_number,$roles,$councils];
            }
        }

        return response()->json(['data' => $users_list]);
    }

    public function getMyAssistance(Request $request)
    {
        $diaries=DB::table('users')
                    ->join('diary_user', 'users.id', '=', 'diary_user.user_id')
                    ->join('diary', 'diary.id', '=', 'diary_user.diary_id')
                    ->select('users.*', 'diary.*')
                    ->where('users.id', '=', $request->user()->id)
                    ->get();

        return response()->json(['data' => $diaries]);
    }

    public function getAssistance(Request $request)
    {
        $diaries=DB::table('users')
                    ->join('diary_user', 'users.id', '=', 'diary_user.user_id')
                    ->join('diary', 'diary.id', '=', 'diary_user.diary_id')
                    ->select('users.*', 'diary.*')
                    ->where('diary.id', '=', $request->diary_id)
                    ->get();

        return response()->json(['data' => $diaries]);
    }

    public function getMyPoints(Request $request)
    {
        $points=User::find($request->user()->id)->points()->where($request->type_status, $request->name_status)->get();

        return response()->json(['data' => $points]);
    }

    public function getMyPosition(Request $request)
    {
        $myPosition=User::find($request->user()->id)->position();

        return response()->json(['data' => $myPosition]);
    }

    public function getMyCouncils(Request $request)
    {
        $myCouncils=User::find($request->user()->id)->councils();

        return response()->json(['data' => $myCouncils]);
    }
}
