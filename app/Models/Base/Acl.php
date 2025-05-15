<?php

namespace App\Models\Base;

use App\Models\Base\BaseModel;
use App\Models\Base\Status;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Metrics\Chartable;

use Illuminate\Support\Facades\Route;

class Acl extends BaseModel 
{
    use RoleAccess, Filterable, AsSource, Chartable;

    /**
     * @var array
     */

    const SYSTEM_ROLE_ID = 2;
    const NOBODY_ROLE_ID = 1;
    const GUEST_ROLE_ID = 3;

    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new Acl;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'acl';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'route',
        'value',
        'role_id',
        'module',
        'method',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'route',
        'value',
        'role_id',
        'module',
        'method',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'route',
        'value',
        'role_id',
        'module',
        'method',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        array('route','role_id','method'),
    ];

    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        if (isset($params['_admin']) && $params['_admin'] == '1')
        {
            $obj->statusText = Status::GL($obj->status);
            $obj->typeText = Status::GL($obj->type);
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

        if ($this->id == self::SYSTEM_ROLE_ID) return false;
        if ($this->id == self::NOBODY_ROLE_ID) return false;
        if ($this->id == self::GUEST_ROLE_ID) return false;

        return true;
    }

    public static function checkAccess($route, $method = 'GET')
    {
        $tall = self::GetObj()->query()->where('route', $route)->where('method', $method)->get();
        $tall = $tall->all();

        if (!count($tall)) return true;

        $needroles = array();
        foreach ($tall as $v)
        {
            if (!$v->value) continue;
            $needroles[] = $v->role_id;
        }

        if (in_array(self::GUEST_ROLE_ID, $needroles)) return true;

        $roles = Auth::user()->roles()->get();
        $roles = $roles->all();

        $existroles = array();
        if(is_array($roles))
        {
            foreach($roles as $v)
            {
                $existroles[] = $v->id;
            }
        }

        $tintesect = array_intersect($needroles, $existroles);
        if (count($tintesect)) return true;

        return false;
    }

    public static function checkAccessRole($str)
    {
        if (!$str || $str == '-1') return true;

        $t = json_decode($str, true);

        if (!$t) return true;

        // ------------------------------------

        $roles = Auth::user()->roles()->get();
        $roles = $roles->all();
        $iduser = Auth::user()->id;

        $existroles = array();
        if(is_array($roles))
        {
            foreach($roles as $v)
            {
                $existroles[] = $v->id;
            }
        }

        foreach ($t as $k => $v)
        {
            if (!in_array($k, $existroles)) continue;
            if (!$v || !is_array($v) || $v == '-1') return true;
            if (in_array($iduser, $v)) return true;
        }

        return false;
    }
    

    public static function getRouteFromGroup($gr = 'web', $contains = false){
        $allRoutes = Route::getRoutes()->compile();
        $attr = $allRoutes['attributes'];
        
        $arr = array();
        foreach($attr as $k => $v)
        {
            $t = explode('.', $k, 2);
            $group = array_shift($t);
            if($group != $gr){
                continue;
            }

            $isGood = true;
            
            if ($contains && strpos($v['uri'], $contains) !== false)
            {
                $isGood = false;
            }

            if ($isGood)
            {
                $arr[$v['action']['as']] = $v['action']['as'];
            }

        }
        return $arr;
    }

}
    
