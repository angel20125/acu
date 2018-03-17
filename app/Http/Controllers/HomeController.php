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
        	return redirect()->route("dashboard");
        }

        return redirect()->route("login");
    }
}
