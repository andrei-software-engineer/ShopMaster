<?php

namespace App\Http\Middleware;

use App\Http\Controllers\User\UserCredentialsController;
use Closure; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckFront
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
     
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return $next($request);
        }else{
            return UserCredentialsController::GetObj()->signIn($request); 
        }
    }
}
