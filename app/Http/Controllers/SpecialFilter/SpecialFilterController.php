<?php

namespace App\Http\Controllers\SpecialFilter;

use App\Models\Base\Status;
use App\Models\Category\Category;
use App\Models\Filter\FilterValue;
use App\Http\Controllers\Controller;


class SpecialFilterController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
        if (self::$MainObj) return self::$MainObj;
        self::$MainObj = new SpecialFilterController;
        return self::$MainObj;
    }


    public function homePageSpecialFilter($id = null)
    {
        $params = $this->homePageSpecialFilter_ProcessId($id);
        $params['topBar'] = $this->homePageSpecialFilterTopBar($params);
        $params['content'] = $this->homePageSpecialFilterContent($params);
        
        return view('BaseSite.HomePage.homePageSpecialFilter', $params);
    }


    protected function homePageSpecialFilter_ProcessId($id = null)
    {
        $params = array();
        $params['objects'] = Status::GA('car_filter');

        $id = (in_array($id, array_keys($params['objects']))) ? $id : Status::SPECIAL_CATEGORY_CATEGORY_AUTO;
        $params['selectedId'] = $id;

        return $params;
    }

    protected function homePageSpecialFilterTopBar($params)
    {
        return view('BaseSite.HomePage.homePageSpecialFilterTopBar', $params);
    }

    protected function homePageSpecialFilterContent($params)
    {
        switch ($params['selectedId']) {
            case Status::SPECIAL_CATEGORY_CATEGORY_AUTO:
                return $this->homePageSpecialFilterContent_Auto($params);
                break;
            case Status::SPECIAL_CATEGORY_CATEGORY_TRUCK:
                return $this->homePageSpecialFilterContent_Truck($params);
                break;
            case Status::SPECIAL_CATEGORY_CATEGORY_BIKE:
                return $this->homePageSpecialFilterContent_Bike($params);
                break;
            case Status::SPECIAL_CATEGORY_CATEGORY_TRANSPORTER:
                return $this->homePageSpecialFilterContent_Transporter($params);
                break;
            case Status::SPECIAL_CATEGORY_CATEGORY_BULDOZER:
                return $this->homePageSpecialFilterContent_Buldozer($params);
                break;
            case Status::SPECIAL_CATEGORY_CATEGORY_TRACTOR:
                return $this->homePageSpecialFilterContent_Tractor($params);
                break;
            default:
                return $this->homePageSpecialFilterContent_Auto($params);
        }
    }

    protected function homePageSpecialFilterContent_Auto($params)
    {
        $params['idParentCategory'] = \config('app.allegro_first_category_marca_car');
        $params['idParentSpecialCategory'] = \config('app.allegro_special_category_marca_car');
        $params['idFilterStatus'] = \config('app.allegro_filter_status_localid');

        $params['mainc'] = $this->homePageSpecialFilterMainCategory(1, $params['idParentCategory']);
        $params['specialc'] = $this->homePageSpecialFilterSpecialCategory(1, $params['idParentSpecialCategory']);
        $params['filtersc'] = $this->homePageSpecialFilterSpecialFilters(1, $params['idFilterStatus']);
 
        $params['idspecialfilter'] = $params['selectedId'];

        return view('BaseSite.HomePage.homePageSpecialFilterContent_Auto', $params);
    }

    protected function homePageSpecialFilterContent_Truck($params)
    {
        $params['idParentCategory'] = \config('app.allegro_first_category_marca_truck');
        $params['idParentSpecialCategory'] = \config('app.allegro_special_category_marca_truck');
        $params['idFilterStatus'] = \config('app.allegro_filter_status_localid');
        
        $params['mainc'] = $this->homePageSpecialFilterMainCategory(1, $params['idParentCategory']);
        $params['specialc'] = $this->homePageSpecialFilterSpecialCategory(1, $params['idParentSpecialCategory']);
        $params['filtersc'] = $this->homePageSpecialFilterSpecialFilters(1, $params['idFilterStatus']);

        $params['idspecialfilter'] = $params['selectedId'];

        return view('BaseSite.HomePage.homePageSpecialFilterContent_Truck', $params);
    }

    protected function homePageSpecialFilterContent_Bike($params)
    {
        $params['idParentCategory'] = \config('app.allegro_first_category_marca_moto');
        $params['idParentSpecialCategory'] = \config('app.allegro_special_category_marca_moto');
        $params['idFilterStatus'] = \config('app.allegro_filter_status_localid');

        $params['mainc'] = $this->homePageSpecialFilterMainCategory(1, $params['idParentCategory']);
        $params['specialc'] = $this->homePageSpecialFilterSpecialCategory(1, $params['idParentSpecialCategory']);
        $params['filtersc'] = $this->homePageSpecialFilterSpecialFilters(1, $params['idFilterStatus']);

        $params['idspecialfilter'] = $params['selectedId'];

        return view('BaseSite.HomePage.homePageSpecialFilterContent_Bike', $params);
    }

    protected function homePageSpecialFilterContent_Transporter($params)
    {
        $params['idParentSpecialCategory'] = \config('app.allegro_special_category_marca_transporter');
        $params['idFilterStatus'] = \config('app.allegro_filter_status_localid');

        $params['specialc'] = $this->homePageSpecialFilterSpecialCategory(1, $params['idParentSpecialCategory']);
        $params['filtersc'] = $this->homePageSpecialFilterSpecialFilters(1, $params['idFilterStatus']);

        $params['idspecialfilter'] = $params['selectedId'];

        return view('BaseSite.HomePage.homePageSpecialFilterContent_Transporter', $params);
    }

    protected function homePageSpecialFilterContent_Buldozer($params)
    {
        $params['idParentSpecialCategory'] = \config('app.allegro_special_category_marca_buldozer');
        $params['idFilterStatus'] = \config('app.allegro_filter_status_localid');

        $params['specialc'] = $this->homePageSpecialFilterSpecialCategory(1, $params['idParentSpecialCategory']);
        $params['filtersc'] = $this->homePageSpecialFilterSpecialFilters(1, $params['idFilterStatus']);

        $params['idspecialfilter'] = $params['selectedId'];

        return view('BaseSite.HomePage.homePageSpecialFilterContent_Buldozer', $params);
    }

    protected function homePageSpecialFilterContent_Tractor($params)
    {
        $params['idParentSpecialCategory'] = \config('app.allegro_special_category_marca_tractor');
        $params['idFilterStatus'] = \config('app.allegro_filter_status_localid');

        $params['specialc'] = $this->homePageSpecialFilterSpecialCategory(1, $params['idParentSpecialCategory']);
        $params['filtersc'] = $this->homePageSpecialFilterSpecialFilters(1, $params['idFilterStatus']);

        $params['idspecialfilter'] = $params['selectedId'];

        return view('BaseSite.HomePage.homePageSpecialFilterContent_Tractor', $params);
    }



    public function homePageSpecialFilterSpecialFilters($level, $idfilter)
    {
        $params['idfilter'] = $idfilter;

        $f = array();
        $f['_where']['idfilter'] = $idfilter;
        $f['_where']['status'] = Status::ACTIVE;

        $params['objects'] = FilterValue::_getAll($f, array('_full' => '1', '_musttranslate' => 1, '_usecache' => '0'));
        // dd($params);
        
        return view('BaseSite.HomePage.homePageSpecialFilterSpecialFilters', $params);
    }

    public function homePageSpecialFilterSpecialCategory($level, $idparentcategory)
    {
        // dd($idparentcategory);
        if ($level > 2) 
        {
            return view('BaseSite.Empty.empty');
        }

        $params['objects'] = [];
        if ($idparentcategory)
        {
            $f = array();
            $f['_where']['idfilter'] = 1;
            // $f['_where']['idparent'] = $idparentcategory;
            $f['_where']['status'] = Status::ACTIVE;

            // $params['objects'] = Category::_getAll($f, array('_full' => '1', '_musttranslate' => 1, '_usecache' => '0'));
            $params['objects'] = FilterValue::_getAll($f, array('_full' => '1', '_musttranslate' => 1, '_usecache' => '0'));

            // dd($params);
        }

        $params['level'] = $level;
        $params['nextlevel'] = $level + 1;
        $params['needNext'] = ($level >= 3) ? false : true;

        $params['name'] = 'idspecialcategory';
        $params['targetid'] = 'homepage_specialfilter_specialc_'. $params['nextlevel'];
        $params['route'] = 'web.specialfilter.homespspecialcategory';

        $params['keyLabel'] = $this->homePageSpecialFilterCategoryGetKeyLabel($level + 3);
        
        return view('BaseSite.HomePage.homePageSpecialFilterCategory', $params);
    }

    public function homePageSpecialFilterMainCategory($level, $idparentcategory)
    {
        if ($level > 3) 
        {
            return view('BaseSite.Empty.empty');
        }


        $params['objects'] = [];
        if ($idparentcategory)
        {
            $f = array();
            // $f['_where']['idparent' ] = 0;
            $f['_where']['idfilter'] = 1;
            $f['_where']['status'] = Status::ACTIVE;

            // $params['objects'] = Category::_getAll($f, array('_full' => '1', '_musttranslate' => 1));
            $params['objects'] = FilterValue::_getAll($f, array('_full' => '1', '_musttranslate' => 1, '_usecache' => '0'));

        }

        $params['level'] = $level;
        $params['nextlevel'] = $level + 1;
        $params['needNext'] = ($level >= 3) ? false : true;

        $params['name'] = 'idmaincategory';
        $params['targetid'] = 'homepage_specialfilter_mainc_' . $params['nextlevel'];
        $params['route'] = 'web.specialfilter.homespmaincategory';

        $params['keyLabel'] = $this->homePageSpecialFilterCategoryGetKeyLabel($level);
        
        return view('BaseSite.HomePage.homePageSpecialFilterCategory', $params);
    }

    protected function homePageSpecialFilterCategoryGetKeyLabel($level = 1)
    {
        if ($level == 1)
            return 'SPF_Marca';

        if ($level == 2)
            return 'SPF_Model';

        if ($level == 3)
            return 'SPF_Modification';

        if ($level == 4)
            return 'SPF_PartsCategory';

        if ($level == 5)
            return 'SPF_PartsType';

        return 'SPF_Marca';
    }

    
    public function homePageSpecialFilterCategory($selectedId = null)
    {
        $params = array();

        $f = array();
        $f['_where']['idparent'] = 0;
        $f['_where']['status'] = Status::ACTIVE;
        
        $params['objects'] = Category::_getAll($f, array('_full' => '1','_musttranslate' => 1, '_usecache' => '0'));
        $params['selectedId'] = $selectedId;

        return view('BaseSite.HomePage.homePageSpecialFilterCategory', $params);
    }


    public function homePageSpecialFilterCategoryType($selectedId = null, $idparent)
    {
        $params = array();

        $f = array();
        $f['_where']['idparent'] = $idparent;
        $f['_where']['status'] = Status::ACTIVE;
        
        $params['objects'] = Category::_getAll($f, array('_full' => '1','_musttranslate' => 1, '_withChildren'=>1, '_usecache' => '0'));
        $params['selectedId'] = $selectedId;
        

        return view('BaseSite.HomePage.homePageSpecialFilterCategoryType', $params);
    }


    public function execSpecialFilter()
    {
        $idspecialfilter = (request()->get('idspecialfilter')) ? (int)request()->get('idspecialfilter') : -1;
        $filter = (request()->get('filter')) ? (array)request()->get('filter') : [];
        $idmaincategory = (request()->get('idmaincategory')) ? (array)request()->get('idmaincategory') : [];
        $idspecialcategory = (request()->get('idspecialcategory')) ? (array)request()->get('idspecialcategory') : [];

        $filter = array_filter($filter);
        $idmaincategory = array_filter($idmaincategory);
        $idspecialcategory = array_filter($idspecialcategory);

        $idmaincategory = (int)end($idmaincategory);
        $idspecialcategory = (int)end($idspecialcategory);

        $params = array();
        // $params['filter'] = $filter;
        $params['filter'] = [];
        if ($idmaincategory)
        {
            $params['filter']['idcategory'] = $idmaincategory;
        } elseif ($idspecialcategory) {
            $params['filter']['idcategory'] = $idspecialcategory;
        }

        foreach ($filter as $k => $v)
        {
            $params['filter'][$k] = implode(',', $v);
        }

        // dd('idspecialfilter', $idspecialfilter, 'filter', $filter, 'idmaincategory', $idmaincategory, 'idspecialcategory', $idspecialcategory,'params', $params);


        // dd($params);
        return redirect()->route('web.product.list', $params);
    }
}