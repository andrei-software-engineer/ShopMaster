<?php

namespace App\GeneralClasses;

use App\Models\Base\BaseModel;
use App\Models\Base\Lang;

class SEOTools extends BaseModel
{
    public static $_title = '';
    public static $_metaKeyWords = '';
    public static $_metaDescription = '';
    public static $_metaAuthor = '';
    public static $_langIndentifier = '';
    public static $_canonical = '';
    public static $_metaImage = '';
    public static $_favicon = '';

    
    public static function getFavicon()
    {
        return config('app.favicon');
    }


    public static function GetGenParams()
    {
        $rez = [];

        $rez['title'] = (self::$_title) ? self::$_title : _GLS('GeneralSiteTitle');
        $rez['metaKeyWords'] = (self::$_metaKeyWords) ? self::$_metaKeyWords : _GLS('GeneralSiteMetaKeyWords');
        $rez['metaDescription'] = (self::$_metaDescription) ? self::$_metaDescription : _GLS('GeneralSiteMetaDescription');
        $rez['metaImage'] = (self::$_metaImage) ? self::$_metaImage : _GLS('GeneralSiteMetaImage');
        $rez['metaAuthor'] = (self::$_metaAuthor) ? self::$_metaAuthor : _GLS('GeneralSiteMetaAuthor');
        $rez['canonical'] = (self::$_canonical) ? self::$_canonical : _GLS('GeneralSiteCanonical');

        return $rez;
    }


    public static function GetHeadParams()
    {
        $rez = self::GetGenParams();

        $rez['langIndentifier'] = Lang::_getSessionId(); // din sesie
        $rez['favicon'] = self::getFavicon();

        return $rez;
    }


    public static function GetHeadearAjax($headers = [])
    {
        $rez = self::GetGenParams();

        $headers = (array) $headers;
        $headers['metaInfo'] = json_encode($rez);

        return $headers;
    }

}