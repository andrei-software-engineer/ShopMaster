<?php

namespace App\Http\Middleware;

use App\Models\Base\Exceptions;
use App\Models\Base\Lang;
use Closure;
use Illuminate\Http\Request;


class CheckLang
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
        if (!Lang::checkLang())
        {
            return Exceptions::errorNotAuthorizedHTML();
        }

        return $next($request);
    }
}
