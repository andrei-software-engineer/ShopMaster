<?php

namespace App\Http\Middleware;

use Closure; 
use App\Models\Base\Acl;
use App\Models\Base\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CheckAcl
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
        $route = Route::getCurrentRoute()->action['as'];

        if (!Acl::checkAccess($route, $request->method()))
        {
            return Exceptions::errorNotAuthorizedHTML();
        }

        return $next($request);
    }
}