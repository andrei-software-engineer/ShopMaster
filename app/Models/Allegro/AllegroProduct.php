<?php

namespace App\Models\Allegro;

class AllegroProduct
{
    static $URL_PRODUCTS = "/sale/products";

    static public function getProducts($categoryId = '', $pageid = '', $limit = 5, &$err = null)
    {
        $url = self::$URL_PRODUCTS;
        $url .= '?';

        if ($limit) $url .= '&limit=' . $limit;
        if ($categoryId) $url .= '&category.id=' . $categoryId;
        if ($pageid) $url .= '&page.id=' . $pageid;

        $url .= '&language=en-US';
        $url .= '&offset=0';
        $url .= '&includeDrafts=0';
        $url .= '&phrase=*';
        $url .= '&mode=GTIN';

        $t = AllegroTools::get($url, $err);
        if ($err) return false;
        return $t;
    }

}