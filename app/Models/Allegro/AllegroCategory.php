<?php

namespace App\Models\Allegro;

class AllegroCategory
{
    static $URL_CATEGORYLIST = "/sale/categories";
    static $URL_CATEGORYEVENTS = "/sale/category-events";

    static public function getCategoryList($parentid = null, &$err = null)
    {
        $url = self::$URL_CATEGORYLIST;
        $url .= '?language=en-US';
        if ($parentid) {
            $url .= '&parent.id=' . $parentid;
        }

        return AllegroTools::get($url, $err);
    }

    static public function getCategoryDetail($categoryId, &$err = null)
    {
        $url = self::$URL_CATEGORYLIST;
        $url .= '/' . $categoryId;

        return AllegroTools::get($url, $err);
    }

    static public function getCategoryParameters($categoryId, &$err = null)
    {
        $url = self::$URL_CATEGORYLIST;
        $url .= '/' . $categoryId . '/parameters';

        return AllegroTools::get($url, $err);
    }

    static public function getCategoryChanges($from, $limit, $type, &$err = null)
    {
        $url = self::$URL_CATEGORYEVENTS;
        $url .= '?';
        $url .= ($from) ? '&from=' . $from : '';
        $url .= ($limit) ? '&limit=' . $limit : '';
        $url .= ($type) ? '&type=' . $type : '';

        return AllegroTools::get($url, $err);
    }

}