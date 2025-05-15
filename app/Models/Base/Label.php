<?php

namespace App\Models\Base;

use App\Models\Base\BaseModel;
use App\Models\Base\Status;
use App\Models\Base\Lang;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Metrics\Chartable;

class Label extends BaseModel 
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
       self::$MainObj = new Label;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'label';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'identifier',
        'status',
        'type',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'identifier',
        'status' => Like::class,
        'type' => Like::class,
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'identifier',
        'status',
        'type',
    ];

    protected $sortCriteria = [
        'identifier' => 'asc',
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        array('identifier', 'type'),
    ];

    protected $_words = [
        '_name',
        '_slug'
    ];
    
    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1')) 
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
        return true;
    }

    // --------------------------------------
    

    // --------------------------------------
	protected static function prepareKey($key)
	{
		$key = preg_replace('/\s+/', '_', $key);
		$key = preg_replace('/[^a-zA-Z0-9_]/', '', $key);
		$key = strtolower($key);
		return $key;
	}

    protected static function saveLabel($key, $type)
	{
        $tobj = self::GetObj();

        $tobj->identifier = $key;
        $tobj->type = $type;
        $tobj->status = Status::PROCESSED;

        $tobj->_systemAttr = array();
        $tobj->_systemAttr['_idlang'] = Lang::_getSessionId();
        
        $tobj->_wordsAttr = array();
        $tobj->_wordsAttr['_name'] = $key;

        $tobj->_save();

        return $tobj->_name;
    }

    protected static function getLabel($key, $type)
	{
        $key = self::prepareKey($key);
        if (!$key) return '[not found]';

        $tobj = Label::GetObj()->where('type', $type)->where('identifier', $key)->first();
        
        if ($tobj == null) {
            return self::saveLabel($key, $type);
        }

        $tobj->processObject($tobj, array('_words' => '1', '_musttranslate' => 1));

        return $tobj->_name;
	}
    

    public static function GL($key){
        return  self::getLabel($key, Status::LABEL_TYPE_SITE);
    }

    public static function GLS($key){
        return  self::getLabel($key, Status::LABEL_TYPE_SYSTEM);
    }

    public static function GLA($key){
        return  self::getLabel($key, Status::LABEL_TYPE_ADMIN);
    }

    public static function GLM($key){
        return  self::getLabel($key, Status::LABEL_TYPE_MESSAGE);
    }

    public static function GLAPI($key){
        return  self::getLabel($key, Status::LABEL_TYPE_API);
    }
}
    
