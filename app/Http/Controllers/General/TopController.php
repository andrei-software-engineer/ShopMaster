<?php

namespace App\Http\Controllers\General;

use App\Models\Base\Status;
use App\Models\Base\SystemMenu;
use App\Models\Product\Product;
use App\Http\Controllers\Controller;
use App\Models\SocialMedia\SocialMedia;


class TopController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
        if (self::$MainObj) return self::$MainObj;
        self::$MainObj = new TopController;
        return self::$MainObj;
    }

    public function execsearchSection()
    {
        $params = array();

        $params['input'] = request()->get('input_info');
        return $this->GetView('BaseSite.Header.resultSearch', $params);
    }

    public function searchSection()
    {
        $params = array();

        return view('BaseSite.Header.execsearch', $params);
    }

    public function logoTipSection()
    {
        $params = array();

        return view('BaseSite.Header.logotip', $params);
    }

    public function topContentSection()
    {
        $params = array();
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;
        $f['_where']['section'] = Status::MENU_SECTION_TOP;

        $params['menus'] =  SystemMenu::_getAll($f, array('_full'=> '1' ,'_musttranslate' => '1', '_usecache' => '0'));

        return view('BaseSite.Header.topContent', $params);
    }

    public function socialMediaSection()
    {
        $params = array();
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;

        $params['menus'] =  SocialMedia::_getAll($f, array('_full'=> '1', '_musttranslate' => '1', '_usecache' => '0'));

        return view('BaseSite.Header.topContent', $params);
    }

    public function userIcon()
    {
        $params = array();

        return view('BaseSite.Header.userIcon', $params);
    }
}