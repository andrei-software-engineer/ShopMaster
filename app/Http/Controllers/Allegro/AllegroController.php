<?php
  
namespace App\Http\Controllers\Allegro;

use App\Models\Allegro\AlgCategory;
use App\Models\Allegro\AlgCategoryForProduct;
use App\Models\Allegro\AlgCategoryParameter;
use App\Models\Allegro\AlgParameter;
use App\Models\Allegro\AlgParameterValue;
use App\Models\Allegro\AlgProduct;
use App\Models\Allegro\AlgSettings;
use App\Models\Allegro\AllegroCategory;
use App\Models\Allegro\AllegroProduct;
use App\Models\Allegro\AllegroToken;
use App\Models\Base\Gallery;
use App\Models\Base\Status;
use App\Models\Base\SystemFile;
use App\Models\Category\Category;
use App\Models\Filter\Filter;
use App\Models\Filter\FilterCategory;
use App\Models\Filter\FilterProduct;
use App\Models\Filter\FilterValue;
use App\Models\Product\Product;
use App\Models\ProductCategory\ProductCategory;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;

class AllegroController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new AllegroController;
       return self::$MainObj;
    }

    public function initToken(Request $request)
    {
        $t = AllegroToken::initAccessToken();
        if ($t == -1)
        {
            echo 'err';
            exit();
        }

        return $this->GetView('allegro/inittoken', ['info' => $t]);
    }

    public function getToken(Request $request, $device_code = '')
    {
        $obj = AllegroToken::getFirstToken($device_code);
        
        if (is_numeric($obj) && $obj == -1)
        {
            echo 'err';
            exit();
        }

        echo 'success';
        exit();
    }

    public function checkToken(Request $request)
    {
        $obj = AllegroToken::checkAccessToken();

        if (is_numeric($obj) && $obj == -1) {
            echo 'err';
            exit();
        }

        echo 'success';
        exit();
    }




    protected function saveCategories($arr)
    {
        $f = [];
        $f['_where']['idallegro'] = $arr['id'];

        $c = AlgCategory::_getCount($f);

        if ($c)
            return;

        $parent = (is_array($arr['parent'])) ? reset($arr['parent']) : $arr['parent'];
        $this->saveCategory($parent);

        $obj = new AlgCategory;

        $obj->idallegro = $arr['id'];
        $obj->name = $arr['name'];
        $obj->parent = $parent;
        $obj->leaf = $arr['leaf'];
        $obj->options = json_encode($arr['options']);
        $obj->levelprocess = 0;
        $obj->infoprocess = time();

        $obj->_save();

        return $obj;
    }

    protected function saveCategory($id)
    {
        if (!$id)
            return;

        $arr = AllegroCategory::getCategoryDetail($id, $err);
        $this->saveCategories($arr);
    }

    protected function loadCategories($idParent = null)
    {
        $objects = AllegroCategory::getCategoryList($idParent, $err);

        if ($err) 
        {
            return true;
        }
        $objects = (isset($objects['categories'])) ? $objects['categories'] : $objects;

        foreach ($objects as $arr)
        {
            $obj = $this->saveCategories($arr);
        }

        return false;
    }

    public function loadMainCategories(Request $request)
    {
        ini_set("default_socket_timeout", 6000);
        // ini_set('max_execution_time', 60);
        ini_set('max_execution_time', 6000);

        $err = $this->loadCategories();

        if($err)
        {
            echo 'err';
            exit();
        }

        echo 'success';
        exit();
    }

    protected function processCategories_0()
    {
        $f = [];
        $f['_where']['levelprocess'] = 0;
        $f['_limit'] = 5;
        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'infoprocess'];
        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'id'];


        $objects = AlgCategory::_getAll($f);

        foreach ($objects as $v)
        {
            $err = $this->loadCategories($v->idallegro);
            if (!$err)
            {
                $v->levelprocess = 1;
                $v->_save();
            } else {
                $v->infoprocess = time();
                $v->_save();
            }
        }

        echo 'success';
        exit();
    }

    protected function saveParameter($arr, $categoryObj)
    {
        $obj = new AlgParameter;

        // ----------------------------------------
        $obj->idallegro = $arr['id'];
        $obj->name = $arr['name'];
        $obj->type = $arr['type'];
        // $obj->required = $arr['required'];
        // $obj->required = $arr['required'];
        // $obj->requiredForProduct = $arr['requiredForProduct'];
        // $obj->requiredIf = $arr['requiredIf'];
        // $obj->displayedIf = $arr['displayedIf'];
        $obj->unit = $arr['unit'];
        
        $obj->options = json_encode($arr['options']);
        $obj->restrictions = json_encode($arr['restrictions']);
        
        $obj->levelprocess = 0;
        $obj->infoprocess = time();

        $obj->_save();
        echo '<BR>' . __FUNCTION__ . ' -> AlgParameter: ' . $obj->name;

        // ----------------------------------------

        // ----------------------------------------
        if (isset($arr['dictionary']))
        {
            $dictionary = (array) $arr['dictionary'];
            foreach ($dictionary as $d)
            {
                $pvObj = new AlgParameterValue;

                $pvObj->idallegroparent = $arr['id'];
                $pvObj->idallegro = $d['id'];
                $pvObj->value = $d['value'];
                $pvObj->depends = json_encode($d['dependsOnValueIds']);
                $pvObj->levelprocess = 0;
                $pvObj->infoprocess = time();

                $pvObj->_save();
                echo '<BR>' . __FUNCTION__ . ' -> AlgParameterValue: ' . $pvObj->value;
            }
        }
        // ----------------------------------------

        $acp = new AlgCategoryParameter;

        $acp->idallegrocategory = $categoryObj->idallegro;
        $acp->idallegroparameter = $obj->idallegro;
        
        $acp->levelprocess = 0;
        $acp->infoprocess = time();

        $acp->_save();

        return false;
    }

    protected function processCategories_1()
    {
        $f = [];
        $f['_where']['levelprocess'] = 1;
        $f['_limit'] = 5;
        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'infoprocess'];
        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'id'];

        $objects = AlgCategory::_getAll($f);

        foreach ($objects as $obj)
        {
            echo '<BR>' . __FUNCTION__ . ' -> category: ' . $obj->name;
            $parameters = AllegroCategory::getCategoryParameters($obj->idallegro);
            $parameters = (isset($parameters['parameters'])) ? $parameters['parameters'] : [];

            $err = false;

            foreach ($parameters as $v)
            {
                $err = $this->saveParameter($v, $obj);
            }
            if (!$err)
            {
                $obj->levelprocess = 2;
                $obj->_save();
            } else {
                $obj->infoprocess = time();
                $obj->_save();
            }
        }

        echo 'success';
        exit();
    }

    protected function saveCategoryToSystem_checkParent($obj)
    {
        if (!$obj->parent)
            return false;

        $f = [];
        $f['_where']['partener'] = AlgSettings::PARTENER_ID;
        $f['_where']['partenerid'] = $obj->parent;

        $c = Category::_getCount($f);
        if ($c)
            return false;
        
        return true;
    }

    protected function saveCategoryToSystem_isSaved($obj)
    {
        $f = [];
        $f['_where']['partener'] = AlgSettings::PARTENER_ID;
        $f['_where']['partenerid'] = $obj->idallegro;

        $c = Category::_getCount($f);
        if ($c)
            return true;
        
        return false;
    }
    
    protected function saveCategoryToSystem_getIdParent($obj)
    {
        if (!$obj->parent) return 0;

        $f = [];
        $f['_where']['partener'] = AlgSettings::PARTENER_ID;
        $f['_where']['partenerid'] = $obj->parent;

        $objects = Category::_getAll($f);
        if (!count($objects))
            return 0;
        $t = reset($objects);
        return $t->id;
    }

    protected function saveCategoryToSystem_getLevel($obj)
    {
        if (!$obj->parent) return 1;

        $f = [];
        $f['_where']['partener'] = AlgSettings::PARTENER_ID;
        $f['_where']['partenerid'] = $obj->parent;

        $objects = Category::_getAll($f);
        if (!count($objects))
            return 1;
        $t = reset($objects);
        return $t->level + 1;
    }

    protected function saveCategoryToSystem($obj)
    {
        $t = $this->saveCategoryToSystem_checkParent($obj);
        if ($t) return true;


        $t = $this->saveCategoryToSystem_isSaved($obj);
        if ($t) return false;


        $categoryObj = new Category;
        $categoryObj->idparent = $this->saveCategoryToSystem_getIdParent($obj);
        $categoryObj->code = '';
        $categoryObj->order = 0;
        $categoryObj->status = Status::NEEDPROCESS;
        $categoryObj->fixed = 1;
        $categoryObj->level = $this->saveCategoryToSystem_getLevel($obj);
        $categoryObj->partener = AlgSettings::PARTENER_ID;
        $categoryObj->partenerid = $obj->idallegro;

        $categoryObj->_setIdLang(AlgSettings::PL_LANG_ID);
        $categoryObj->_setWord('_name', $obj->name);
        
        $categoryObj->_save();
        
        return false;
    }

    protected function processCategories_2()
    {
        $f = [];
        $f['_where']['levelprocess'] = 2;
        $f['_limit'] = 5;
        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'infoprocess'];
        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'id'];

        $objects = AlgCategory::_getAll($f);

        foreach ($objects as $obj)
        {
            $err = $this->saveCategoryToSystem($obj);
            
            if (!$err)
            {
                $obj->levelprocess = 3;
                $obj->_save();
            } else {
                $obj->infoprocess = time();
                $obj->_save();
            }
        }

        echo 'success';
        exit();
    }
    protected function saveCategoryForProduct_isSaved($obj)
    {
        $f = [];
        $f['_where']['idallegro'] = $obj->idallegro;

        $c = AlgCategoryForProduct::_getCount($f);
        if ($c)
            return true;

        return false;
    }

    protected function saveCategoryForProduct($obj)
    {
        $t = $this->saveCategoryForProduct_isSaved($obj);
        if ($t)
            return false;

        $newObj = new AlgCategoryForProduct;

        $newObj->idallegro = $obj->idallegro;
        $newObj->levelprocess = 0;
        $newObj->infoprocess = time();

        $newObj->_save();

        return false;
    }

    protected function processCategories_3()
    {
        $f = [];
        $f['_where']['levelprocess'] = 3;
        $f['_limit'] = 5;
        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'infoprocess'];
        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'id'];

        $objects = AlgCategory::_getAll($f);

        foreach ($objects as $obj)
        {
            $err = $this->saveCategoryForProduct($obj);
            
            if (!$err)
            {
                $obj->levelprocess = 4;
                $obj->_save();
            } else {
                $obj->infoprocess = time();
                $obj->_save();
            }
        }

        echo 'success';
        exit();
    }

    public function processCategories(Request $request, $levelprocess = -1)
    {
        ini_set("default_socket_timeout", 6000);
        // ini_set('max_execution_time', 60);
        ini_set('max_execution_time', 6000);

        switch ($levelprocess) {
            case 0:
                return $this->processCategories_0();
            case 1:
                return $this->processCategories_1();
            case 2:
                return $this->processCategories_2();
            case 3:
                return $this->processCategories_3();
        }
        
        echo 'success';
        exit();
    }

    public function loadChangesCategories(Request $request)
    {
        ini_set('max_execution_time', 60);

        $cv = $from = AlgSettings::getConfig(AlgSettings::CHANGE_CATEGORIES_CREATED_ID);
        $limit = 10;
        $type = 'CATEGORY_CREATED';

        $objects = AllegroCategory::getCategoryChanges($from, $limit, $type);
        $objects = (isset($objects['events'])) ? $objects['events'] : $objects;

        foreach ($objects as $v)
        {
            $this->saveCategory($v['category']['id']);
            $cv = $v['id'];
        }

        AlgSettings::saveConfig(AlgSettings::CHANGE_CATEGORIES_CREATED_ID, $cv);

        echo 'success';
        exit();
    }

    protected function saveParameterToSystem_checkCategies($obj)
    {
        $f = [];
        $f['_where']['idallegroparameter'] = $obj->idallegro;

        $all = AlgCategoryParameter::_getAll($f);

        foreach ($all as $v)
        {
            $f = [];
            $f['_where']['partener'] = AlgSettings::PARTENER_ID;
            $f['_where']['partenerid'] = $v->idallegrocategory;

            $c = Category::_getCount($f);
            if (!$c)
                return true;
        }

        return false;
    }

    protected function saveParameterToSystem_getType($obj)
    {
        if ($obj->type == 'dictionary')
        {
            return Status::FILTER_TYPE_VALUE;
        }
        if ($obj->type == 'string')
        {
            return Status::FILTER_TYPE_STRING;
        }
        if (
                $obj->type == 'float'
                || $obj->type == 'integer'
            )
        {
            return Status::FILTER_TYPE_RANGE;
        }
        return Status::FILTER_TYPE_VALUE;
    }

    protected function saveParameterToSystem_getMinValue($obj)
    {
        if (
                $obj->type == 'dictionary'
                || $obj->type == 'string'
            )
        {
            return 0;
        }

        $r = json_decode($obj->restrictions);
        if (!is_array($r)) return 0;
        if (!isset($r['min'])) return 0;

        return $r['min'];
    }

    protected function saveParameterToSystem_getMaxValue($obj)
    {
        if (
                $obj->type == 'dictionary'
                || $obj->type == 'string'
            )
        {
            return 0;
        }

        $r = json_decode($obj->restrictions);
        if (!is_array($r)) return 0;
        if (!isset($r['max'])) return 0;

        return $r['max'];
    }

    protected function saveParameterToSystem($obj)
    {
        $t = $this->saveParameterToSystem_checkCategies($obj);
        if ($t)
            return true;

        $filterObj = new Filter;
        $filterObj->orderctireatia = 0;
        $filterObj->type = $this->saveParameterToSystem_getType($obj);
        $filterObj->minValue = $this->saveParameterToSystem_getMinValue($obj);
        $filterObj->maxValue = $this->saveParameterToSystem_getMaxValue($obj);
        $filterObj->status = Status::NEEDPROCESS;
        $filterObj->identifier = $obj->name;
        $filterObj->partener = AlgSettings::PARTENER_ID;
        $filterObj->partenerid = $obj->idallegro;

        $filterObj->_setIdLang(AlgSettings::PL_LANG_ID);
        $filterObj->_setWord('_name', $obj->name);

        $filterObj->_save();

        // ---------------------------------------------
        if ($obj->type == 'dictionary') {

            $f = [];
            $f['_where']['idallegroparent'] = $obj->idallegro;
            $f['_limit'] = 50;

            $all = AlgParameterValue::_getAll($f);

            foreach ($all as $v)
            {
                $vfilterObj = new FilterValue;
                $vfilterObj->idfilter = $filterObj->id;
                $vfilterObj->orderctireatia = 0;
                $vfilterObj->status = Status::NEEDPROCESS;
                $vfilterObj->partener = AlgSettings::PARTENER_ID;
                $vfilterObj->partenerid = $v->idallegro;
                
                $vfilterObj->_setIdLang(AlgSettings::PL_LANG_ID);
                $vfilterObj->_setWord('_name', $v->value);

                $vfilterObj->_save();
            }

            if (count($all))
                return true;
        }
        // --------------------------------------------

        // --------------------------------------------
        $f = [];
        $f['_where']['idallegroparameter'] = $obj->idallegro;
        $f['_limit'] = 50;

        $all = AlgCategoryParameter::_getAll($f);
        // dd($all);

        foreach ($all as $v) {
            $f = [];
            $f['_where']['partener'] = AlgSettings::PARTENER_ID;
            $f['_where']['partenerid'] = $v->idallegrocategory;
            $f['_limit'] = 50;

            $allCat = Category::_getAll($f);
            foreach ($allCat as $tcat)
            {
                $tfcatobj = new FilterCategory;
                $tfcatobj->idcategory = $tcat->id;
                $tfcatobj->idfilter = $filterObj->id;

                $tfcatobj->_save();
            }
            if (count($allCat))
                return true;
        }

        if (count($all))
            return true;
        // --------------------------------------------

        // dd($all);

        return false;
    }

    protected function processParameter_0()
    {
        $f = [];
        $f['_where']['levelprocess'] = 0;
        $f['_limit'] = 5;
        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'infoprocess'];
        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'id'];

        $objects = AlgParameter::_getAll($f);

        foreach ($objects as $obj) {
            $err = $this->saveParameterToSystem($obj);

            if (!$err) {
                $obj->levelprocess = 1;
                $obj->_save();
            } else {
                $obj->infoprocess = time();
                $obj->_save();
            }
        }

        echo 'success';
        exit();
    }

    public function processParameter(Request $request, $levelprocess = -1)
    {
        ini_set("default_socket_timeout", 6000);
        // ini_set('max_execution_time', 60);
        ini_set('max_execution_time', 6000);

        switch ($levelprocess) {
            case 0:
                return $this->processParameter_0();
        }
        
        echo 'success';
        exit();
    }

    protected function processProducts_0_getCategory_Id($force = true)
    {
        $categoryId = AlgSettings::getConfig(AlgSettings::PROCESS_PRODUCTS_CURRENT_CATEGORYID);

        if ($categoryId)
            return $categoryId;

        AlgSettings::saveConfig(AlgSettings::PROCESS_PRODUCTS_CURRENT_NEXTPAGEID, '');

        $f = [];
        $f['_where']['levelprocess'] = 0;
        $f['_limit'] = 1;
        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'infoprocess'];
        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'id'];

        $objects = AlgCategoryForProduct::_getAll($f);

        if (count($objects))
        {
            $obj = reset($objects);

            $categoryId = $obj->idallegro;
            AlgSettings::saveConfig(AlgSettings::PROCESS_PRODUCTS_CURRENT_CATEGORYID, $categoryId);
            return $categoryId;
        }

        if (!$force)
            return -1;

        $f = [];
        $f['_where']['levelprocess'] = 0;
        $f['_update'] = [];
        $f['_update']['levelprocess'] = 1;
        $f['_update']['infoprocess'] = time();

        $c = AlgCategoryForProduct::_updateAll($f);
        
        return $this->processProducts_0_getCategory_Id(false);
    }

    protected function processProducts_0_getPage_Id()
    {
        return AlgSettings::getConfig(AlgSettings::PROCESS_PRODUCTS_CURRENT_NEXTPAGEID);
    }

    protected function processProducts_0_finishCategory($categoryId)
    {
        $f = [];
        $f['_where']['idallegro'] = $categoryId;
        $f['_limit'] = 1;
        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'infoprocess'];
        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'id'];

        $all = AlgCategoryForProduct::_getAll($f);
        if (count($all))
        {
            $obj = reset($all);
            $obj->levelprocess = '1';
            $obj->infoprocess = time();

            $obj->_save();
        }

        AlgSettings::saveConfig(AlgSettings::PROCESS_PRODUCTS_CURRENT_CATEGORYID, '');
        AlgSettings::saveConfig(AlgSettings::PROCESS_PRODUCTS_CURRENT_NEXTPAGEID, '');
    }

    protected function saveAlgProduct($arr)
    {
        $f = [];
        $f['_where']['idallegro'] = $arr['id'];

        $c = AlgProduct::_getCount($f);

        if ($c)
            return;

        $obj = new AlgProduct;

        
        $obj->idallegro = $arr['id'];
        $obj->name = $arr['name'];
        $obj->category = json_encode($arr['category']);
        $obj->parameters = json_encode($arr['parameters']);
        $obj->images = json_encode($arr['images']);
        $obj->description = json_encode($arr['description']);
        $obj->isdraft = json_encode($arr['isDraft']);
        $obj->levelprocess = 0;
        $obj->infoprocess = time();
        
        $obj->_save();

        return $obj;
    }

    protected function processProducts_0()
    {
        $categoryId = $this->processProducts_0_getCategory_Id();
        $pageId = $this->processProducts_0_getPage_Id();

        $rez = AllegroProduct::getProducts($categoryId, $pageId);

        if ($rez === false)
        {
            $this->processProducts_0_finishCategory($categoryId);

            echo 'success';
            exit();
        }

        $products = (isset($rez['products'])) ? (array) $rez['products'] : [];
        $categories = (isset($rez['categories'])) ? (array) $rez['categories'] : [];
        $filters = (isset($rez['filters'])) ? (array) $rez['filters'] : [];
        $nextPage = (isset($rez['nextPage'])) ? (array) $rez['nextPage'] : [];

        foreach ($products as $v)
        {
            $obj = $this->saveAlgProduct($v);
        }

        if (is_array($nextPage) && isset($nextPage['id']))
        {
            AlgSettings::saveConfig(AlgSettings::PROCESS_PRODUCTS_CURRENT_NEXTPAGEID, $nextPage['id']);
        } else
        {
            $this->processProducts_0_finishCategory($categoryId);
        }

        echo 'success';
        exit();
    }
    
    protected function saveProductToSystem_isSaved($obj)
    {
        $f = [];
        $f['_where']['partener'] = AlgSettings::PARTENER_ID;
        $f['_where']['partenerid'] = $obj->idallegro;

        $c = Product::_getCount($f);
        if ($c)
            return true;

        return false;
    }

    protected function saveProductToSystem_isCategoriesSaved($obj)
    {
        $objCategory = json_decode($obj->category, true);

        if (!isset($objCategory['id']))
            return true;

        $ids = (is_array($objCategory['id'])) ? $objCategory['id'] : array($objCategory['id']);
        if (isset($objCategory['similar']) && is_array($objCategory['similar'])) {
            foreach ($objCategory['similar'] as $v) {
                if (!is_array($v))
                    continue;
                if (!isset($v['id']))
                    continue;
                $ids[] = $v['id'];
            }
        }
        $ids = array_unique($ids);

        foreach ($ids as $v)
        {
            if (!$v) continue;

            $f = [];
            $f['_where']['partener'] = AlgSettings::PARTENER_ID;
            $f['_where']['partenerid'] = $v;

            $c = Category::_getCount($f);
            if (!$c)
                return false;
        }
        
        return true;;
    }

    protected function saveProductToSystem_isFilterSaved($arr)
    {
        $f = [];
        $f['_where']['partener'] = AlgSettings::PARTENER_ID;
        $f['_where']['partenerid'] = $arr['id'];

        $c = Filter::_getCount($f);
        if (!$c)
            return false;

        $valuesIds = (isset($arr['valuesIds'])) ? ( (is_array($arr['valuesIds'])) ? $arr['valuesIds'] : array($arr['valuesIds'])  ) : [];

        foreach ($valuesIds as $v)
        {
            $f = [];
            $f['_where']['partener'] = AlgSettings::PARTENER_ID;
            $f['_where']['partenerid'] = $v;

            $c = FilterValue::_getCount($f);
            if (!$c)
                return false;
        }

        return true;
    }

    protected function saveProductToSystem_processDescription_Item($item)
    {
        if (!is_array($item)) return '';
        if (!isset($item['type'])) return '';

        if (strtolower($item['type']) == 'text') 
        {
            $content = (isset($item['content'])) ? $item['content'] : '';
            return '<div>'. $content.'</div>';
        }

        return '';
    }

    protected function saveProductToSystem_processDescription($obj)
    {
        $objDescription = json_decode($obj->description, true);
        if (!is_array($objDescription)) return '';
        if (!isset($objDescription['sections'])) return '';

        $sections = $objDescription['sections'];

        if (!is_array($sections))
            return '';

        $description = '';

        foreach ($sections as $section)
        {
            if (!is_array($section))
                continue;
            
            if (!isset($section['items']) || !is_array($section['items']))
            {
                $description .= $this->saveProductToSystem_processDescription_Item($section);
            } else
            {
                $items = $section['items'];
                foreach ($items as $item)
                {
                    $description .= $this->saveProductToSystem_processDescription_Item($item);
                }
            }
        }

        return $description;
    }

    protected function saveProductToSystem_saveCategory($obj, $productObj)
    {
        $objCategory = json_decode($obj->category, true);

        if (!isset($objCategory['id'])) return;

        $ids = (is_array($objCategory['id'])) ? $objCategory['id'] : array($objCategory['id']);
        if (isset($objCategory['similar']) && is_array($objCategory['similar']))
        {
            foreach ($objCategory['similar'] as $v)
            {
                if (!is_array($v)) continue;
                if (!isset($v['id'])) continue;
                $ids[] = $v['id'];
            }
        }
        $ids = array_unique($ids);

        foreach ($ids as $v) {
            if (!$v)
                continue;

            $f = [];
            $f['_where']['partener'] = AlgSettings::PARTENER_ID;
            $f['_where']['partenerid'] = $v;

            $all = Category::_getAll($f);
            if (!count($all))
                continue;
            $categoryObj = reset($all);

            $newObj = new ProductCategory;
            $newObj->idcategory = $categoryObj->id;
            $newObj->idproduct = $productObj->id;

            $newObj->_save();
        }

        return;
    }

    protected function saveProductToSystem_saveFilter($obj, $productObj)
    {
        $objParameters = json_decode($obj->parameters, true);

        if (!is_array($objParameters))
            return;

        $fparams = [];
        $fparams['_admin'] = '1';
        // $fparams['_musttranslate'] = '1';
        $fparams['_idlang'] = AlgSettings::EN_LANG_ID;

        foreach ($objParameters as $item)
        {
            $f = [];
            $f['_where']['partener'] = AlgSettings::PARTENER_ID;
            $f['_where']['partenerid'] = $item['id'];

            $filters = Filter::_getAll($f, $fparams);

            if (!count($filters))
                continue;

            $filterObj = reset($filters);
            if (!isset($filterObj->_name) || !$filterObj->_name)
            {
                $filterObj->_idlang = AlgSettings::EN_LANG_ID;
                $filterObj->_name = $item['name'];
                $filterObj->_save();
            }

            $unit = (isset($item['unit']) && !is_array($item['unit']) && $item['unit']) ? $item['unit'] : '';


            if (isset($item['valuesIds']))
            {
                $valuesIds = (isset($item['valuesIds'])) ? ((is_array($item['valuesIds'])) ? $item['valuesIds'] : array($item['valuesIds'])) : [];

                foreach ($valuesIds as $k => $v) {

                    $f = [];
                    $f['_where']['partener'] = AlgSettings::PARTENER_ID;
                    $f['_where']['partenerid'] = $v;
                    $f['_where']['idfilter'] = $filterObj->id;

                    $filtersvalues = FilterValue::_getAll($f, $fparams);

                    if (!count($filtersvalues))
                        continue;
                    $tvalfilterobj = reset($filtersvalues);

                    $newObj = new FilterProduct;
                    $newObj->idproduct = $productObj->id;
                    $newObj->idfilter = $filterObj->id;
                    $newObj->idfiltervalue = $tvalfilterobj->id;
                    $newObj->value = '';
                    $newObj->unit = $unit;

                    $newObj->_setIdLang(AlgSettings::EN_LANG_ID);
                    $newObj->_setWord('_name', '');

                    $newObj->_save();
                }
            } else
            {
                $valuesLabels = (isset($item['valuesLabels'])) ? ( (is_array($item['valuesLabels'])) ? $item['valuesLabels'] : array($item['valuesLabels']) ) : [];
                $values = (isset($item['values'])) ? ( (is_array($item['values'])) ? $item['values'] : array($item['values']) ) : [];

                foreach ($values as $k => $v)
                {
                    if (!$v) continue;
                    $tlabel = (isset($valuesLabels[$k])) ? $valuesLabels[$k] : '';
                           
                    $newObj = new FilterProduct;
                    $newObj->idproduct = $productObj->id;
                    $newObj->idfilter = $filterObj->id;
                    $newObj->idfiltervalue = 0;
                    $newObj->value = $v;
                    $newObj->unit = $unit;
                    
                    $newObj->_setIdLang(AlgSettings::EN_LANG_ID);
                    $newObj->_setWord('_name', $tlabel);

                    $newObj->_save();

                }
            }
        }

        return;
    }

    protected function saveProductToSystem_saveImages($obj, $productObj)
    {
        $objImages = json_decode($obj->images, true);

        if (!is_array($objImages))
            return;

        foreach ($objImages as $v)
        {
            if (!is_array($v)) continue;
            if (!isset($v['url']))
                continue;

            $fileObj = new SystemFile;
            $fileObj->name = '';
            $fileObj->size = 0;
            $fileObj->filetype = 'url';
            $fileObj->location = $v['url'];
            $fileObj->md5 = md5($v['url']);
            $fileObj->isused = '1';
            $fileObj->permission = '-1';
            $fileObj->group = 'allegroimg';

            $fileObj->_save();

            $galleryObj = new Gallery;
            $galleryObj->status = Status::ACTIVE;
            $galleryObj->parentmodel = 'product';
            $galleryObj->isdefault = 0;
            $galleryObj->idsystemfile = $fileObj->id;
            $galleryObj->ordercriteria = 0;
            $galleryObj->parentmodelid = $productObj->id;

            $galleryObj->_save();
        }

        return;
    }
    protected function saveProductToSystem($obj)
    {
        $t = $this->saveProductToSystem_isSaved($obj);
        if ($t)
            return false;

        // -----------------------------

        $t = $this->saveProductToSystem_isCategoriesSaved($obj);
        if (!$t)
            return true;

        $objParameters = json_decode($obj->parameters, true);
        foreach($objParameters as $v)
        {
            $t = $this->saveProductToSystem_isFilterSaved($v);
            if (!$t)
                return true;
        }

        // -----------------------------

        $productObj = new Product;
        $productObj->code = '';
        $productObj->order = 0;
        $productObj->status = Status::NEEDPROCESS;
        $productObj->fixed = 0;
        $productObj->partener = AlgSettings::PARTENER_ID;
        $productObj->partenerid = $obj->idallegro;

        $_description = $this->saveProductToSystem_processDescription($obj);

        $productObj->_setIdLang(AlgSettings::EN_LANG_ID);
        $productObj->_setWord('_name', $obj->name);
        $productObj->_setText('_description', $_description);

        $productObj->_save();

        // -----------------------------------------------------
        $this->saveProductToSystem_saveCategory($obj, $productObj);
        $this->saveProductToSystem_saveFilter($obj, $productObj);
        $this->saveProductToSystem_saveImages($obj, $productObj);
        // -----------------------------------------------------

        return false;
    }

    protected function processProducts_1()
    {
        $f = [];
        $f['_where']['levelprocess'] = 0;
        $f['_limit'] = 10;
        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'infoprocess'];
        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'id'];

        $objects = AlgProduct::_getAll($f);

        foreach ($objects as $v) {
            $err = $this->saveProductToSystem($v);
            if (!$err) {
                $v->levelprocess = 1;
                $v->_save();
            } else {
                $v->infoprocess = time();
                $v->_save();
            }
        }

        echo 'success';
        exit();
    }

    protected function processProducts_2_saveProduct_Id($id = 0)
    {
        AlgSettings::saveConfig(AlgSettings::PROCESS_PRODUCTS_CURRENT_PRODUCTID, $id);
        return $id;
    }

    protected function processProducts_2_getProduct_Id()
    {
        $id = AlgSettings::getConfig(AlgSettings::PROCESS_PRODUCTS_CURRENT_PRODUCTID);

        if ($id)
            return $id;

        return $this->processProducts_2_saveProduct_Id();
    }

    protected function processProducts_2_checkProduct($obj)
    {
        $f = [];
        $f['_where']['idproduct'] = $obj->id;

        $isActive = false;

        $objects = ProductCategory::_getAll($f, array('_full' => '1', ));

        if (!count($objects))
        {
            $isActive = true;
        } else
        {
            foreach ($objects as $v)
            {
                if ($v->categoryObj->status != Status::ACTIVE)
                    continue;

                $isActive = true;
                break;
            }
        }

        if ($isActive)
        {
            $obj->status = Status::ACTIVE;
            $obj->_save();
        }

        
    }

    protected function processProducts_2()
    {
        $idProduct = $this->processProducts_2_getProduct_Id();

        $f = [];
        $f['_where']['id'] = ['_act' => '>', $idProduct];
        $f['_where']['status'] = Status::NEEDPROCESS;
        $f['_limit'] = 10;

        $f['_orderby'][] = ['_d' => 'asc', '_c' => 'id'];

        $nextId = $idProduct;

        $objects = Product::_getAll($f);

        if (!count($objects))
        {
            $this->processProducts_2_saveProduct_Id();

            echo 'success';
            exit();
        }

        foreach ($objects as $v) {
            $nextId = $v->id;
            $this->processProducts_2_checkProduct($v);
        }

        $this->processProducts_2_saveProduct_Id($nextId);
        
        echo 'success';
        exit();
    }

    public function processProducts(Request $request, $levelprocess = -1)
    {
        ini_set("default_socket_timeout", 6000);
        // ini_set('max_execution_time', 60);
        ini_set('max_execution_time', 6000);

        switch ($levelprocess) {
            case 0:
                return $this->processProducts_0();
            case 1:
                return $this->processProducts_1();
            case 2:
                return $this->processProducts_2();
        }
        
        echo 'success';
        exit();
    }
}