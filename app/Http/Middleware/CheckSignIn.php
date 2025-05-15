<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Profile\ProfileController;
use Closure; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSignIn
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
            return ProfileController::GetObj()->profile($request);
        }else{
            return $next($request);
        }
    }
}
