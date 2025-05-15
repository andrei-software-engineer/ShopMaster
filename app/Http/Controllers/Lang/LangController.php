<?php

namespace App\Http\Controllers\Lang;

use App\GeneralClasses\GeneralCL;
use App\Models\Base\Status;
use App\Models\Base\Lang;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

use Closure; 
use Illuminate\Http\Request;

class LangController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
        if (self::$MainObj) return self::$MainObj;
        self::$MainObj = new LangController;
        return self::$MainObj;
    }


    public function langSection()
    {
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;
    
        $objects = Lang::_getAll($f, array('_full' => true, '_musttranslate' => 1, '_usecache' => '0'));

        // dd(request()->route('langslug'));
        // dd(Lang::_getSessionId());
        // dd(route('web.langProfile', ['langslug' => 'xx', 'id' =>'zzz']));
        // dd(Route::currentRouteName());

        $routeParams = [];
    
        $params = array();
        $params['objects'] = $objects;
        $params['_backUrl'] = Route::currentRouteName();
        $params['_langId'] = Lang::_getSessionId();
        $params['_params'] = json_encode($routeParams);


        return view('BaseSite.BaseViews.partials.language', $params);
    }


    public function execchangeLg()
    {

        Lang::changeLangById(request()->get('id'));

        $_params = request()->get('_params');
        $params = ($_params) ? json_decode($_params, true) : [];

        $route = url()->previous();
        $route = ($route) ? $route : route('web.index');
        // $route = GeneralCL::getRoute($route, $params);

        return redirect()->to($route); 
    }
}