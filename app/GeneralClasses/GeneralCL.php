<?php

namespace App\GeneralClasses;

use App\Models\Base\BaseModel;
use App\Models\Base\Lang;

class GeneralCL extends BaseModel
{
    static public function getUrlPrefix($withSlash = true)
    {
        $slug = Lang::_getSessionSlug();
        $slug = str_replace('/', '', $slug);
        $slug = ($slug) ? '/'.$slug : '';

        $rez = env('APP_URL') . $slug;
        $rez .= ($withSlash) ? '/' : '';
        return $rez;
    }

    static public function getRoute($route, $params = [])
    {
        $params = (array) $params;
        $route = str_replace('langprefix|', '', $route);
        $route = ($route) ? $route : 'web.index';

        $slug = Lang::_getSessionSlug();
        $slug = str_replace('/', '', $slug);
        
        if ($slug)
        {
            $params['langslug'] = $slug;
            $route = 'langprefix|' . $route;
        }

        return route($route, $params);
    }

    static public function prepareUrlById($slug, $id, $route = "")
    {
        if ($slug) {
            return self::getUrlPrefix() . $slug;
        }

        $params = [];
        if ($id)
            $params['id'] = $id;


        return self::getRoute($route, $params);


    }
    static public function prepareUrlBySlug($slug, $route = "")
    {
        return self::prepareUrlById($slug, NULL, $route);
    }
}