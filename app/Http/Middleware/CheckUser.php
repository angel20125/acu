<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\View;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::getCurrent();
        if(!$user)
        {
            return redirect()->route("login");
        }

        View::share('user', $user);
        
        $current_date = new \DateTime("now");
        $current_date = $current_date->format("Y-m-d");

        View::share('current_date', $current_date);

        $current_date_format = new \DateTime("now");
        $current_date_format = $current_date_format->format("d/m/Y");
        
        View::share('current_date_format', $current_date_format);

        return $next($request);
    }
}
