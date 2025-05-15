<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Faq\FaqController;
use App\Models\Base\SystemMenu;
use App\Models\Category\Category;
use Illuminate\Http\Request;

class UserMenuController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;


    public static function GetObj()
    {
        if (self::$MainObj)
            return self::$MainObj;
        self::$MainObj = new UserMenuController;
        return self::$MainObj;
    }

    public function index(Request $request)
    {
        //
    }

    public static function userMenu()
    {

        $params['_userMenu'] = self::userLeftMenu();

        return view('BaseSite.User.userMenu', $params);
    }

    public static function userLeftMenu(): array
    {
        $rez = array();

        $rez['objects'] = [];
        $rez['level'] = 1;

        // ---------------------------
        $t = new SystemMenu();
        $t->_name = _GL('UM_profile');
        $t->url = route('web.profile');
        $t->_childrens = [];
        $t->_isActive = false;
        $rez['objects'][] = $t;
        // ---------------------------

        // // ---------------------------
        $t = new SystemMenu();
        $t->_name = _GL('UM_settings');
        $t->url = route('web.settings');   
        $t->_childrens = [];
        $rez['objects'][] = $t;
        // // ---------------------------

        // // ---------------------------
        $t = new SystemMenu();
        $t->_name = _GL('UM_my_orders');
        $t->url = route('web.myOrders').'/?page=1';   
        $t->_childrens = [];
        $rez['objects'][] = $t;
        // // ---------------------------

        // // ---------------------------
        $t = new SystemMenu();
        $t->_name = _GL('UM_favorite');
        $t->url = route('web.favorite');   
        $t->_childrens = [];
        $rez['objects'][] = $t;
        // // ---------------------------
        
        // // // ---------------------------
        // $t = new SystemMenu();
        // $t->_name = _GL('UM_logout');
        // $t->url = route('web.execLogout');   
        // $rez['objects'][] = $t;
        // // // ---------------------------
        

        return $rez;
    }



}