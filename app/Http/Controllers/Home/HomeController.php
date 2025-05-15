<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Base\Status;
use App\Models\Benefits\Benefits;
use App\Models\Filter\FilterValue;
use App\Models\Page\Page;
use App\Models\Product\Product;

class HomeController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
        if (self::$MainObj)
            return self::$MainObj;
        self::$MainObj = new HomeController;
        return self::$MainObj;
    }


    public function homePageBrandList()
    {
        $f = array();
        // $f['_where']['idfilter'] = \config('app.allegro_filter_brand_localid');
        $f['_where']['status'] = Status::ACTIVE;

        $objects = FilterValue::_getAll($f, array('_full' => '1', '_musttranslate' => 1, '_usecache' => 0));

        $params = array();
        $params['objects'] = [];
        foreach ($objects as $v) {
            $params['objects'][] = $this->homePageBrandListItem($v)->render();
        }

        return view('BaseSite.HomePage.homePageBrandList', $params);
    }

    protected static function homePageBrandListItem($obj)
    {
        $params['obj'] = $obj;

        return view('BaseSite.HomePage.homePageBrandListItem', $params);
    }


    public function homePageProductVisitedList()
    {
        $params = array();

        $f = [];
        $f['_where']['status'] = Status::ACTIVE;
        $f['_start'] = 0;
        $f['_limit'] = _CGC('vizitedproductshome');


        $objects = Product::_getAll($f, array('_full' => '1', '_musttranslate' => 1, '_usecache' => 0, '_cachelifetime' => 600));

        $params['objects'] = [];
        foreach ($objects as $v) {
            $params['objects'][] = $this->productListHomeTemplate($v)->render();
        }

        return view('BaseSite.HomePage.homePageProductVisitedList', $params);
    }

    protected function productListHomeTemplate($obj)
    {
        $params['obj'] = $obj;

        return view('BaseSite.Product.productItem', $params);
    }

    public function homePageBenefits()
    {
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;

        $params = array();
        $benefits = Benefits::_getAll($f, array('_full' => '1', '_usecache' => '0'));
        $params['objs'] = $benefits;

        return view('BaseSite.Benefits.benefits', $params);
    }

    public function homeInfo()
    {
        $params = array();

        $params['obj'] = Page::_get(config('app.homeInfoID'), array('_full' => '1', '_usecache' => '0'));

        return view('BaseSite.HomePage.homeInfo', $params);
    }


}