<?php

namespace App\Http\Controllers\Menu;

use App\Models\Base\Status;
use App\Models\Base\SystemMenu;
use App\Http\Controllers\Controller;


class MenuController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
        if (self::$MainObj) return self::$MainObj;
        self::$MainObj = new MenuController;
        return self::$MainObj;
    }

    public function menuSectionTop()
    {
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;
        $f['_where']['section'] = Status::MENU_SECTION_TOP;
        $f['_where']['idparent'] = 0;

        $objects = SystemMenu::_getAll($f, array('_full'=> 1, '_withChildren' => 1, '_musttranslate' => 1, '_usecache' => '0'));

        $params = array();
        $params['level'] = '1';
        $params['objects'] = $objects;    

        return view('BaseSite.BaseViews.partials.mainMenu', $params);
    }

    public function menuSectionMain()
    {
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;
        $f['_where']['section'] = Status::MENU_SECTION_MAIN;
        $f['_where']['idparent'] = 0;

        $objects = SystemMenu::_getAll($f, array('_full'=> 1, '_withChildren' => 1 , '_musttranslate' => 1, '_usecache' => '0'));

        $params = array();
        $params['level'] = '1';
        $params['objects'] = $objects;

        return view('BaseSite.BaseViews.partials.mainMenu', $params);
    }


    public function menuSectionBottom()
    {
        $params = array();
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;
        $f['_where']['section'] = Status::MENU_SECTION_BOTTOM;

        $params['menus'] =  SystemMenu::_getAll($f, array('_full'=> 1 , '_musttranslate' => 1, '_usecache' => '0'));

        return view('BaseSite.Footer.bottomContent', $params);
    }
    

}