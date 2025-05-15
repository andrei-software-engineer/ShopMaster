<?php

namespace App\Http\Middleware;

use App\Models\Base\Lang;
use Closure; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ChangeLang
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
        $langRoute = $request->route('langslug');
        $langSession = $request->session()->all();

        
        if(in_array("lang", $langSession)){
            $langSession = $langSession['lang']['code2'];
        }else{
            $langSession['lang'] = [];
        }

        return $next($request);

        if($langRoute != $langSession) 
        {
            Lang::changeLang($langRoute);
        }

        return $next($request);
    }
}
