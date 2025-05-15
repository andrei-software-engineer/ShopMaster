<?php

namespace App\Http\Controllers\Filter;

use App\GeneralClasses\AjaxTools;
use App\Models\Base\Status;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Select;
use App\Models\Filter\FilterValue;
use App\Http\Controllers\Controller;
use App\Models\Filter\FilterCategory;
use App\GeneralClasses\ProcessFilter;
use App\Http\Controllers\Category\CategoryController;

class FilterController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
        if (self::$MainObj) return self::$MainObj;
        self::$MainObj = new FilterController;
        return self::$MainObj;
    }

    public function index(Request $request)
    {
        //
    }


    public static function filtersLeftPart($p)
    {
        $rez = array();

        $f = array();

        if ($p['categoryobj'] == false || !isset($p['categoryobj'])) {
            $f['_where']['id'] = \config('app.filter_value_limit_elements_productlist');

        }else {
            $f['_where']['idcategory'] = $p['categoryobj']->id;
        }

        $objects = FilterCategory::_getAll($f, array('_full' => '1', '_musttranslate' => 1, '_usecache' => '0'));

        foreach ($objects as $v) {
            $t = false;

            if ($v->filterObj->type == Status::FILTER_TYPE_RANGE) {
                $t = self::filtersLeftPart_Range($v->filterObj, $p)->render();
            }

            if ($v->filterObj->type == Status::FILTER_TYPE_VALUE) {
                $t = self::filtersLeftPart_Value($v->filterObj, $p)->render();
            }

           
            if (!$t) continue;
            $rez[] = $t;
        }

        
        return $rez;
    }


    protected static function filtersLeftPart_OtherFilter($objFilter, $p)
    {
        $params = [];

        $otherFilters = [];
        foreach($p['filter'] as $k => $v)
        {
            if ($k == $objFilter->id)
                continue;

            $otherFilters[$k] = $v;
        }
        if (!count($otherFilters))
            return view('BaseSite.Empty.empty');

        
        $params['otherFilters'] = $otherFilters;

        return view('BaseSite.Filter.otherFilters', $params);
    }


    protected static function filtersLeftPart_Value($objFilter, $p)
    {
        $params = [];
        $params['otherFilters'] = self::filtersLeftPart_OtherFilter($objFilter, $p);

        $params['checkedVals'] = (isset($p['filter'][$objFilter->id])) ? $p['filter'][$objFilter->id] : [];
        $params['obj'] = $objFilter;
        $params['idfilter'] = $objFilter->id;
        $params['idcategory'] =  ($p['category']) ? $p['category']->id : '';

        $params['filterValues'] = (count($params['checkedVals'])) ? self::loadFilterValue_Local($objFilter->id, $params['checkedVals'])->render() : '';
        $params['isloaded'] = ($params['filterValues']) ? '1' : '0';

        return view('BaseSite.Filter.filterLeftPartValue', $params);
    }

    public static function loadFilterValue($id)
    {
        return self::loadFilterValue_Local($id);
    }

    protected static function loadFilterValue_Local($id, $vals = [])
    {
        $params = [];
        $params['idfilter'] = $id;
        $params['checkedVals'] = $vals;
        
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;
        $f['_where']['idfilter'] = $id;
        $f['_limit'] = \config('app.filter_value_limit_elements');

        $params['filterValues'] = FilterValue::_getAll($f, ['_full' => '1', '_musttranslate' => '1', '_usecache' => '0']);

        return view('BaseSite.Filter.loadFilterValue_Local', $params);
    }


    public static function  execfiltersLeftPart_Value(Request $request)
    {
        $params = [];
        $filter = request()->get('filter');
        $params['filter'] = ProcessFilter::filterProces($filter, $params);
        $params['id'] = request()->get('idcategory');

        AjaxTools::$_ajaxCommands[] = ['name' => 'jscChangeBrowserLocation', 'href' => route('web.category', $params)];
        
        return CategoryController::GetObj()->categoryPageXXX($params);
    }

    protected static function filtersLeftPart_Range($objFilter, $p)
    {
        $params = [];
        $params['otherFilters'] = self::filtersLeftPart_OtherFilter($objFilter, $p);
        $params['filterRange'] = $p['filter'];
        $params['obj'] = $objFilter;
        $params['idfilter'] = $objFilter->id;
        $params['idcategory'] =  ($p['category']) ? $p['category']->id : '';

        return view('BaseSite.Filter.filterLeftPartRange', $params);

    }


    public function execSelectFilterValue(Request $request)
    {
        $x = array();
        $x['_where']['idfilter'] = $request['idfilter'];
        $f['_where']['status'] = Status::ACTIVE;
        $filters_value = FilterValue::_getAllForSelect($x, array('_full' => '1', '_musttranslate' => 1), '_name');

        $selected = $request['idselected'];

        return Select::make('obj.idfiltervalue')
            ->class('js_CA_select')
            ->value($selected)
            ->options($filters_value)
            ->title(_GLA('TI_idfiltervalue'))
            ->placeholder(_GLA('PH_select idfiltervalue'));
    }
}
