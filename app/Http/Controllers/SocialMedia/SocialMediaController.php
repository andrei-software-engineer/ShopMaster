<?php

namespace App\Http\Controllers\SocialMedia;

use App\Models\Base\Status;
use App\Http\Controllers\Controller;
use App\Models\SocialMedia\SocialMedia;

class SocialMediaController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
        if (self::$MainObj) return self::$MainObj;
        self::$MainObj = new SocialMediaController;
        return self::$MainObj;
    }

    public function socialMediaFooterSection()
    {
        $params = array();
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;

        $params['_socialMedia'] =  SocialMedia::_getAll($f, array('_full'=> 1, '_musttranslate' => 1, '_usecache' => '0'));

        return view('BaseSite.SocialMedia.socialMediaFooterContainer', $params);
    }

    public function socialMediaTopSection()
    {
        $params = array();
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;

        $params['_socialMedia'] =  SocialMedia::_getAll($f, array('_full'=> 1, '_musttranslate' => 1, '_usecache' => '0'));

        return view('BaseSite.SocialMedia.socialMediaTopContainer', $params);
    }

}