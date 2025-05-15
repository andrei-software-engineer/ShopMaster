<?php

namespace App\Models\Base;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Filterable;
use Illuminate\Pagination\Paginator;
use stdClass;

class Paginate extends Paginator
{
    use RoleAccess, Filterable, AsSource, Chartable;

    public static function getPaginateHtml($currPag, $totpag, $prefix, $suffix, $jsClass = '', $targetId = '')
    {

        $params = array();
        $links = self::getLinks($currPag, $totpag, $prefix, $suffix, $jsClass, $targetId);
        $params['links'] = self::getLinks($currPag, $totpag, $prefix, $suffix, $jsClass, $targetId);
        $params['nextPage'] = self::nextPage($currPag, $totpag, $prefix, $suffix, $jsClass, $targetId);
        $params['prevPage'] = self::prevPage($currPag, $prefix, $suffix, $jsClass, $targetId);
        $params['firstPage'] = self::firstPage($currPag, $prefix, $suffix, $jsClass, $targetId);
        $params['lastPage'] = self::lastPage($currPag, $totpag, $prefix, $suffix, $jsClass, $targetId);

        return view('BaseSite.Pagination.pagination', $params);
    }

    protected static function getPageUrl($prefix, $suffix, $page, $currPag, $name = '', $jsClass = '', $targetId = '')
    {
        $obj = new stdClass();
        $obj->url = $prefix . $page . $suffix;
        $obj->name = ($name) ? $name : $page;
        $obj->current = ($page == $currPag) ? true : false;
        $obj->jsClass = $jsClass;
        $obj->targetId = $targetId;

        return $obj;
    }

    public static function getLinks($currPag, $totpag, $prefix, $suffix = '', $jsClass = '', $targetId = '')
    {
        $links = array();

        for ($x = 1; $x <= $totpag; $x++) {
            $links[] = self::getPageUrl($prefix, $suffix, $x, $currPag, '', $jsClass, $targetId);
        }

        return $links;
    }

    public static function nextPage($currPag, $totpag, $prefix, $suffix, $jsClass = '', $targetId = '')
    {
        if ($currPag >= $totpag)
            return false;
        $page = $currPag + 1;

        return self::getPageUrl($prefix, $suffix, $page, $currPag, '>', $jsClass, $targetId);
    }

    public static function prevPage($currPag, $prefix, $suffix, $jsClass = '', $targetId = '')
    {
        if ($currPag == 1)
            return false;
        $page = $currPag - 1;

        return self::getPageUrl($prefix, $suffix, $page, $currPag, '<', $jsClass, $targetId);
    }

    public static function firstPage($currPag, $prefix, $suffix, $jsClass = '', $targetId = '')
    {
        if ($currPag == 1)
            return false;
        $page = 1;

        return self::getPageUrl($prefix, $suffix, $page, $currPag, '<<', $jsClass, $targetId);
    }

    public static function lastPage($currPag, $totpag, $prefix, $suffix, $jsClass = '', $targetId = '')
    {
        if ($currPag >= $totpag)
            return false;
        $page = $totpag;

        return self::getPageUrl($prefix, $suffix, $page, $currPag, '>>', $jsClass, $targetId);
    }

    public static function getParams($request, $total, $params = [])
    {
        $p = (array) $params;

        $cPage = (isset($p['page']) && $p['page']) ? $p['page'] : 0;
        if ($cPage < 1) {

            if (isset($request->query->all()['page'])) {
                $cPage = $request->query->all()['page'];
            } else {
                $cPage = 1;
            }
        }

        $obj = new stdClass();
        $onpag = (isset($p['od']) && isset($p['od']['op'])) ? (int) $p['od']['op'] : 10;
        if ($onpag < 1)
            $onpag = 10;
        $obj->currPag = $cPage;


        $obj->start = ($obj->currPag - 1) * $onpag;
        $obj->limit = $onpag;
        $obj->totalpag = ceil($total / $onpag);

        return $obj;
    }
}