<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Diary;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function getAdminDashboard()
    {
        $date = new \DateTime();
        $date->modify('first day of this month');

        $new_date = new \DateTime();
        $new_date->modify('first day of this month')->add(new \DateInterval("P1M"));

    	$diaries=Diary::orderBy("event_date","desc")->where("event_date",">=",$date->format("Y-m-d"))->where("event_date","<",$new_date->format("Y-m-d"))->get();

    	$calendar=[];
    	foreach($diaries as $key => $diary) 
    	{
    		$calendar[]=[\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d") => $diary->id];
    	}

    	return view("main.admin_dashboard",["diaries"=>$diaries,"calendar"=>$calendar]);
    }
}
