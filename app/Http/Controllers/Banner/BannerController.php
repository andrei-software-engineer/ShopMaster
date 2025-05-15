<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;


class BannerController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
        if (self::$MainObj) return self::$MainObj;
        self::$MainObj = new BannerController;
        return self::$MainObj;
    }


    public function prepareBanner()
    {
        $params = array();

        return $this->GetView('BaseSite.BannerPage.banner', $params);
    }

}