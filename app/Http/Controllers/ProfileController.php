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
            return "Iniciaste sesión con un rol tipo: ".$user->getCurrentRol()->name;
        	//Proximamente va redirigir al dashboard
            //return redirect()->route("dashboard");
        }

        return redirect()->back()->withErrors("Datos incorrectos, verifique por favor");
    }
}
