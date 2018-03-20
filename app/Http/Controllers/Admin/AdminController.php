<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function getAdminDashboard()
    {
    	return view("main.admin_dashboard");
    }
}
