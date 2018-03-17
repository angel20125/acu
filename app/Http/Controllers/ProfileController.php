<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\User;

class ProfileController extends Controller
{
    public function postLogin()
    {
        $data = Input::only('email','password');

        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']], true))
    	{
            $user = User::getCurrent();
            $user->verifyRole();
            return redirect()->route("dashboard");
        }

        return redirect()->back()->withErrors("Datos incorrectos, verifique por favor");
    }

    public function getDashboard()
    {
        return view("main.admin_dashboard");
    }
}
