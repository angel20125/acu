<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ProfileController extends Controller
{
    public function postLogin()
    {
        $data = Input::only('email','password');

        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']], true))
    	{
        	//Proximamente va redirigir al dashboard
            //return redirect()->route("dashboard");
            return "Usuario verificado";
        }

        return redirect()->back()->withErrors("Datos incorrectos, verifique por favor");
    }
}
