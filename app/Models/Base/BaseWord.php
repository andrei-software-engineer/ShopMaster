<?php

namespace App\Models\Base;

use App\Models\Base\BaseModel;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class BaseWord extends BaseModel
{
    use AsSource, Filterable, Attachable;

    /**
     * @var array
     */

    public $table = null;

    public $timestamps = false;

    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj($table)
    {
       $obj = new BaseWord();
       $obj->table = $table;
       $obj->setTable($table);
       return $obj;
    } 
    // --------------------------------------------

    protected $fillable = [
        'id',
        'idparent',
        'idlang',
        'attr', //de ex: name, info, …
        'value',
    ];

    protected $_keys = [
        'id',
        array('idparent', 'idlang', 'attr'),
    ];

    
    public  function processObject($obj, $params)
    {
    }    
    
    public function _remove($table){
        $this->setTable($table);
        parent::_delete();
    }
}
