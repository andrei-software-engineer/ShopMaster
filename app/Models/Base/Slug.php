<?php

namespace App\Models\Base;

use App\Models\Base\BaseModel;
use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Metrics\Chartable;


use App\Http\Controllers\Page\PageController;

class Slug extends BaseModel 
{
    use RoleAccess, Filterable, AsSource, Chartable;

    /**
     * @var array
     */

    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new Slug;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'slug';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'slug',
        'idlang',
        'parentmodel',
        'parentmodelid',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'slug',
        'idlang',
        'parentmodel',
        'parentmodelid',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'slug',
        'idlang',
        'parentmodel',
        'parentmodelid',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        array('slug', 'idlang')
    ];

    protected $_words = [
        '_name',
    ];
    
    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {
            $obj->canDelete = $obj->_canDelete();

        }

        return $obj;
    }

    public function _canDelete()
    {       
        $t =  parent::_canDelete();
        if(!$t){
            return false;
        }
        return true;
    }

    public static function prepareUrl($slug, $id, $route = "")
    {
        if($slug)
        {
            return env('APP_URL')."/".$slug;
        }

        return route($route, $id);
    }

    public static function prepareUrl2($slug,  $route = "")
    {
        if($slug)
        {
            return env('APP_URL')."/".$slug;
        }

        return route($route);
    }

    private static function getSlugObj($arr, $shift = false) {
        if ($shift) $t = array_shift($arr);

        $arr = array_filter($arr);
        if (!count($arr)) return false;

        $conc = implode('/',$arr);
        $conc = trim($conc, '/');
        return Slug::GetObj()->where('slug', $conc)->first();
    }

    private static function getSpecVarFromRequest($request, $nr_slugs = 10) {
        $arr = array();
        for ($i = 1; $i <= $nr_slugs; $i++) {
            $t = 'var'.$i;
            if (!isset($request->$t)) continue;
            if (!$request->$t) continue;
            $arr[] = $request->$t;
        }

        $arr = array_filter($arr);
        return $arr;
    }

    public static function prepareSlug($request, $nr_slugs = 10) {
        $arr = self::getSpecVarFromRequest($request, $nr_slugs);
        $obj = self::getSlugObj($arr);
        if (!$obj) self::getSlugObj($arr, true);
        if (!$obj) return Exceptions::errorNotFoundHTML();


        // -----------------------------------------------
        $t = self::checkParentModel($obj);
        if ($t)  return $t;

        // -----------------------------------------------

        // -----------------------------------------------
        // $t = self::checkParentModel($obj);
        // if ($t)  return $t; .......

        // -----------------------------------------------

        return Exceptions::errorNotFoundHTML();
    }

    private static function checkParentModel($obj)
    {
        $t = self::checkParentModel_Page($obj);
        if ($t) return $t;

        return false;
    }

    private static function checkParentModel_Page($obj)
    {
        $z = '';
        if ($obj->parentmodel == 'page')
            $z = PageController::checkParentModel($obj);
            if($z) return $z;

        return false;
    }
}