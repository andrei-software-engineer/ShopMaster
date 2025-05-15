<?php

namespace App\GeneralClasses;

use App\Models\Base\BaseModel;
use App\Models\Base\Status;
use App\Models\Category\Category;

class ProcessFilter extends BaseModel
{
    public static function parseCategory($data = array(), &$params)
    {
        $exist = false;
        $params['categoryparents'] = [];
        if (is_array($params) && isset($params['categoryobj']))
        {
            $exist = true;
            // return $params['categoryobj'];
            
        } elseif (is_array($params) && isset($params['idcategory']))
        {
            $exist = true;
            $obj = Category::_get($params['idcategory'], array('_full' => '1', '_musttranslate' => 1));
            $params['categoryobj'] = $obj;
            // return $params['categoryobj'];
        
        } elseif (request()->get('idcategory'))
        {
            $exist = true;
            $idcategory = request()->get('idcategory');
            $obj = Category::_get($idcategory, array('_full' => '1', '_musttranslate' => 1));
            $params['categoryobj'] = $obj;
            // return $params['categoryobj'];
        } elseif (is_array($params) && isset($params['category'])) {
            $exist = true;
            $params['categoryobj'] = $params['category'];
            // return $params['categoryobj'];

        } else
        {
            $params['categoryobj'] = false;
        }

        if (!$exist)
            return false;

        $parents = [];

        $localId = \config('app.allegro_first_category_localid');
        $tobj = $params['categoryobj'];

        if (!$tobj)
            return false;

        while ($tobj->idparent && $tobj->idparent != $localId)
        {
            $nobj = Category::_get($tobj->idparent, ['_full' => '1', '_musttranslate' => 1, '_usecache' => 1, '_cachelifetime' => 2592000]);
            $parents[] = $nobj;
            $tobj = $nobj;
        }

        $params['categoryparents'] = array_reverse($parents);

        return $params['categoryobj'];
    }


    public static function filterProces($filter = array())
    {
        $rez= array();

        if(!empty($filter)){

            $filter = (array) $filter;

            foreach ($filter as $k => $v)
            {
                if (!$k)
                    continue;

                $v = (is_array($v)) ? $v : explode(',', $v);
                $v = (array) $v;
                $v = array_filter($v);

                if (!count($v)) continue;
                $rez[$k] = $v;
            }
        }

        return $rez;
    }

    public static function otherDataProces($od = array())
    {
        $od = (array) $od;

        $rez = [];
        
        $rez['op'] = (isset($od['op'])) ? (int)$od['op'] : (int)_CGC('productDefaultOnPage');
        if ($rez['op'] < 1)
            $rez['op'] = 10;

        $rez['o'] = (isset($od['o'])) ? (int)$od['o'] : (int)Status::ORDER_BY_NAME_ASC;

        return $rez;
    }

    public static function pageProces($od = array())
    {
        if (isset(request()->query->all()['page'])) {
            $rez = request()->query->all()['page'];
        } else {
            $rez = 1;
        }

        if ($rez < 1) $rez = 1;

        return $rez;
    }

    public static function getUrlPatrams($params, $excluded = [])
    {
        $excluded = (array) $excluded;
        $params = (array) $params;


        $rez = [];

        if (!in_array('page', $excluded))
        {
            if ($params['page']) {
                $rez['page'] = $params['page'];
            }
        }

        if (!in_array('idcategory', $excluded))
        {
            if (isset($params['category']) && $params['category']) {
                $rez['idcategory'] = $params['category']->id;
            } elseif (isset($params['categoryobj']) && $params['categoryobj']) {
                $rez['idcategory'] = $params['categoryobj']->id;
            }
        }

        if (isset($params['filter'])) {
            foreach ($params['filter'] as $k => $v) {
                if (in_array('f_' . $k, $excluded))
                    continue;

                $rez['filter'][$k] = implode(',', $v);
            }
        }


        if (!in_array('op', $excluded)) {
            if (isset($params['od']) && isset($params['od']['op']))
            {
                if (!isset($rez['od']))
                {
                    $rez['od'] = [];
                }
                $rez['od']['op'] = $params['od']['op'];
            }
        }

        if (!in_array('o', $excluded)) {
            if (isset($params['od']) && isset($params['od']['o']))
            {
                if (!isset($rez['od']))
                {
                    $rez['od'] = [];
                }
                $rez['od']['o'] = $params['od']['o'];
            }
        }

        return $rez;
    }

}