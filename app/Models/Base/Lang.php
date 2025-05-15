<?php

namespace App\Models\Base;

use App\Models\Base\BaseModel;
use App\Models\Base\Status;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Metrics\Chartable;


class Lang extends BaseModel
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
       self::$MainObj = new Lang;
       return self::$MainObj;
    }
    // --------------------------------------------

    public $table = 'lang';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'slug',
        'name',
        'code2',
        'code3',
        'status',
        'codehtml',
        'status_admin',
        'ordercriteria',
        'right_direction',
    ];

    protected $allowedFilters = [
        'id'          => Like::class,
        'slug',
        'name',
        'code2',
        'code3',
        'status'        => Like::class,
        'codehtml',
        'status_admin'    => Like::class,
        'ordercriteria'      => Like::class,
        'right_direction'    => Like::class,
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'slug',
        'name',
        'code2',
        'code3',
        'status',
        'codehtml',
        'status_admin',
        'ordercriteria',
        'right_direction',
    ];

    protected $sortCriteria = [
        'ordercriteria' => 'asc'
        , 'name' => 'asc'
    ];

    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {
            $obj->statusText = Status::GL($obj->status);
            $obj->rightDirectionText = Status::GL($obj->right_direction);
            $obj->statusAdminText = Status::GL($obj->status_admin);
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

    public static function _getSessionId() {
        return self::_getSessionGen('id');
    }

    public static function _getSessionSlug() {
        return self::_getSessionGen('slug');
    }

    protected static function _getSessionGen($field, $stop = false) {
        $insess = self::_getSession('lang');
        
        if (!$insess)
        {
            if ($stop) return null;
            self::_setDefaultSession();
            return self::_getSessionGen($field, true);
        }
        return $insess[$field];
    }

    public static function _getLangNAME(){
        $rez = self::_getSession('lang')['code2'];
        
        return $rez;
    }

    public static function _setDefaultSession() {

        $obj = self::query()->where('code2', env('DEFAULT_LANG_CODE2', 'ro'))->first();

        $arr = array();
        $arr['id'] = $obj->id;
        $arr['slug'] = $obj->slug;
        $arr['name'] = $obj->name;
        $arr['code2'] = $obj->code2;
        $arr['code3'] = $obj->code3;
        $arr['codehtml'] = $obj->codehtml;
        $arr['status_admin'] = $obj->status_admin;
        $arr['right_direction'] = $obj->right_direction;

        self::_putSession('lang', $arr);
    }

    public static function _getDropDownAdminLanguages(){
        $data = self::all()->where('status_admin', Status::ACTIVE ); 

        $rez = array();

        foreach($data as $v){
            $rez[$v->id] = $v->name;
            
        }
        return $rez;
    }

    public static function checkLang()
    {
        //
    }

    public static function getLangs()
    {
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;
    
        $obj = Lang::_getAll($f, array('_full' => true, '_musttranslate' => 1, '_usecache' => '0'));
    
        $params = array();
        $params['objs'] = $obj;

        foreach($obj as $v){
            $params['routes'][$v->code2] = route(Route::currentRouteName(), ['langslug' => $v->code2]);
        }

        return $params;
    }

    public static function changeLang($langRoute)
    {
        $obj = self::query()->where('code2', $langRoute)->first();

        self::setChangeLang($obj);
    }

    public static function changeLangById($id)
    {
        $id = (int) $id;
        $obj = self::query()->where('id', $id)->first();
        if ($obj->status != Status::ACTIVE) return;

        self::setChangeLang($obj);
    }

    protected static function setChangeLang($obj)
    {
        $arr = array();
        $arr['id'] = $obj->id;
        $arr['slug'] = $obj->slug;
        $arr['name'] = $obj->name;
        $arr['code2'] = $obj->code2;
        $arr['code3'] = $obj->code3;
        $arr['codehtml'] = $obj->codehtml;
        $arr['status_admin'] = $obj->status_admin;
        $arr['right_direction'] = $obj->right_direction;

        self::_putSession('lang', $arr);
    }
}