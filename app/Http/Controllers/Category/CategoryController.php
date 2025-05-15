<?php

namespace App\Http\Controllers\Category;

use App\Models\Base\Slug;
use App\Models\Base\Status;
use Illuminate\Http\Request;
use App\Models\Base\SystemMenu;
use App\Models\Category\Category;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Faq\FaqController;
use App\Http\Controllers\Product\ProductController;

class CategoryController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;


    public static function GetObj()
    {
        if (self::$MainObj)
            return self::$MainObj;
        self::$MainObj = new CategoryController;
        return self::$MainObj;
    }


    public static function checkParentModel(Slug $obj)
    {
        if ($obj->parentmodel != 'category')
            return false;

        return self::GetObj()->categoryDetail($obj->parentmodelid, '');
    }


    public function index(Request $request)
    {
        //
    }

    public function categoryPage(Request $request)
    {
        return $this->categoryDetail($request->id, '');
    }


    public function categoryPageXXX($params)
    {
        return $this->categoryDetail($params['id'], $params['filter']);
    }

    public function categoryDetail($id, $filter)
    {
        $obj = Category::_get($id, array('_full' => '1', '_musttranslate' => 1));

        $params = array();
        $params['categoryobj'] = $obj;
        $params = $this->categorySetBreadcrumbs($params);
        
        if ($obj) {
            $params['_FaqList'] = FaqController::GetFAQ('category', $obj->id);
        }

        if($filter){
            $params['specFilter'] = $filter;
        }

        return ProductController::GetObj()->productList_inter($params);
    }



    public static function categorySection()
    {
        $f = array();
        $f['_where']['idparent'] = 0;
        $f['_where']['status'] = Status::ACTIVE;

        $obj = Category::_getAll($f, array('_full' => '1','_musttranslate' => 1, '_usecache' => '0', '_cachelifetime' => 2592000, '_withChildren' => 1));

        $params = array();
        $params['objs'] = $obj;
        $params['level'] = '1';

        return view('BaseSite.Category.categoryLevels', $params);
    }


    public static function categoryLeftPart($params)
    {
        $categoryparents = (isset($params['categoryparents'])) ? (array) $params['categoryparents'] : [];
        $categoryobj = (isset($params['categoryobj'])) ? $params['categoryobj'] : false;
        $localId = (int)\config('app.allegro_first_category_localid');
        if ($categoryobj)
            $categoryparents[] = $categoryobj;

        if (!count($categoryparents))
        {
            return self::categoryLeftPartLevel($localId, -1, $categoryobj, []);
        }


        $tobj = array_shift($categoryparents);

        return self::categoryLeftPartLevel($tobj->idparent, $tobj->id, $categoryobj, $categoryparents, 1);

    }

    public static function categoryLeftPartLevel($idparent, $currentId, $categoryobj, $categoryparents, $level = 1)
    {
        $f = [];
        $f['_where']['status'] = Status::ACTIVE;
        $f['_where']['idparent'] = $idparent;

        $objects = Category::_getAll($f, ['_full' => '1', '_musttranslate' => '1', '_usecache' => '0', '_cachelifetime' => 2592000]);

        if(!count($objects))
        {
            return view('BaseSite.Empty.empty', []);
        }

        $params['objects'] = [];
        foreach ($objects as $v) {
            $params['objects'][] = self::categoryLeftPartLevelItem($v, $idparent, $currentId, $categoryobj, $categoryparents, $level)->render();
        }

        $params['level'] = $level;

        return view('BaseSite.Category.categoryLeftPartLevel', $params);
    }

    protected static function categoryLeftPartLevelItem($obj, $idparent, $currentId, $categoryobj, $categoryparents, $level)
    {
        $params = [];
        $params['level'] = $level;
        $params['obj'] = $obj;
        $params['isselected'] = ($currentId == $obj->id) ? true : false;

        $params['childs'] = '';

        if ($params['isselected'] && count($categoryparents))
        {
            $tobj = array_shift($categoryparents);
            $nl = $level + 1;

            $params['childs'] = self::categoryLeftPartLevel($tobj->idparent, $tobj->id, $categoryobj, $categoryparents, $nl)->render();
        } elseif($params['isselected'])
        {
            $tobj = array_shift($categoryparents);
            $nl = $level + 1;

            $params['childs'] = self::categoryLeftPartLevel($obj->id, -1, $categoryobj, $categoryparents, $nl)->render();
        }


        return view('BaseSite.Category.categoryLeftPartLevelItem', $params);
    }

    public static function categoryLeftPartItem($obj, $p)
    {
        $params = [];
        $params['isselected'] = false;
        $params['obj'] = $obj;
        $params['childs'] = [];

        if ($p['category'] && $p['category']->id == $obj->id)
        {
            $params['isselected'] = true;
            $f = [];
            $f['_where']['status'] = Status::ACTIVE;
            $f['_where']['idparent'] = $obj->id;
            $params['childs'] = Category::_getAll($f, ['_full' => '1' ,'_musttranslate' => '1', '_usecache' => '0', '_cachelifetime' => 2592000]);
        }
        
        
        return view('BaseSite.Category.categoryLeftPartItem', $params);
    }


    public function getHomeCategories()
    {
        $f = array();
        $params = array();
        // $f['_where']['idparent'] = \config('app.allegro_first_category_localid');
        $f['_where']['status'] = Status::ACTIVE;

        $objects = Category::_getAll($f, array('_full' => '1' ,'_musttranslate' => '1', '_usecache' => '0', ));

        $params['objects'] = [];
        foreach ($objects as $v) {
            $params['objects'][] = $this->getHomeCategoriesItem($v)->render();
        }

        return view('BaseSite.Category.homeCategories', $params);
    }

    protected static function getHomeCategoriesItem($obj)
    {
        $params['obj'] = $obj;

        return view('BaseSite.Category.homeCategoriesItem', $params);
    }


    protected function categorySetBreadcrumbs($params, $info = [])
    {
        $params['_breadcrumbs'] = [];

        $t = new SystemMenu();
        $t->_name = ($params['categoryobj'] && $params['categoryobj']->_name) ? $params['categoryobj']->_name : 'nu exista';
        $t->url = '';

        $params['_breadcrumbs'][] = $t;

        return $params;
    }
}
