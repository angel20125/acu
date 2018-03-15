<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    public function index()
    {
        $user = User::getCurrent();

        if($user)
        {
        	//Proximamente va redirigir al dashboard
            //return redirect()->route("dashboard");
            return "Usuario verificado";
        }

        return view("user.login");
    }
}
