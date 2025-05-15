<?php

namespace App\Models\Filter;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\Status;
use App\Models\Product\Product;
use Symfony\Component\Uid\Uuid;
use Orchid\Screen\Fields\ViewField;

class FilterProduct extends BaseModel 
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
       self::$MainObj = new FilterProduct;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'filterproduct';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idproduct',
        'idfilter',
        'idfiltervalue',
        'value',
        'unit',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idproduct',
        'idfilter',
        'idfiltervalue',
        'value',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idproduct',
        'idfilter',
        'idfiltervalue',
        'value',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        array('identifier', 'type'),
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
            $filter = Filter::_get($obj->idfilter, array('_admin' => '1','_musttranslate' => 1, 'usecache' => '1'));
            $obj->filter_identifier = ($filter && $filter->identifier) ? $filter->identifier : 'nu exista ';

            $filterValue = FilterValue::_get($obj->idfiltervalue, array('_admin' => '1','_musttranslate' => 1, 'usecache' => '1'));
            $obj->filterValue_name = ($filterValue && $filterValue->_name) ? $filterValue->_name : 'nu exista ';

            $obj->canDelete = $obj->_canDelete();
        }

        return $obj;
    }

    public function _setParams()
    {
        if (!$this) return;
        $this->_setFilterProduct();
    }


    public function _canDelete()
    {       
        $t =  parent::_canDelete();
        if(!$t){
            return false;
        }
        return true;
    }

    public static function locationselect($name = '', $selected = 0, $cilds = '', $idfilter = 0)
	{
        
        $r = request();
        $params = array();
        $params['chids'] =  $cilds;
        $title = _GLA('Select Filter Value');
		if ($r->get('name')) $name = $r->get('name');
		$idfilter = ($r->get('idlparent')) ? (int)$r->get('idlparent') : $idfilter;
         
		if (!$name) return view('BaseSite.Empty.empty');

		if ($idfilter == -1) 
		{		
			return view('BaseSite.Empty.empty'); 
		}
             
		if ($selected)
		{
			$obj = FilterValue::_get($selected ,array('_admin' => '1', '_musttranslate' => 1));
               
			if ($obj->idfilter)
			{
				$params['name'] = $name;
				$params['id'] = 'id_sel_' . $name;
				$params['targid'] = $name . '_targid_' . $idfilter;
	
				$params['chids'] = $cilds;
				$params['selected'] = (int)$selected;
                
				$params['prefLink'] = 'platform.execselectadmin';
				$params['title'] = $title;

                $f = array();
                $f['_where']['idfilter'] = $obj->idfilter;
                $f['_where']['status'] = Status::ACTIVE;
                // $all = FilterValue::_getAll($f, array('_admin' => '1', '_musttranslate' => 1));
                $all = FilterValue::_getAll($f, array('_admin' => '1', '_musttranslate' => 1, '_usecache' => '0'));
                $params['objects'] = $all;
                $cilds = (!count($all)) ? view('BaseSite.Empty.empty')->render() : ViewField::make('obj.' . $name)
                    ->view('Orchid.selectGeneral')
                    ->set('params', $params)->render();
                
                      
                return self::locationselect($name, $obj->idfilter, $cilds, 0);
			}
           
		}
        
		$preparedname = str_replace('[','_',$name);
		$preparedname = str_replace(']','_',$preparedname);
		$params['name'] = $name;
		$params['id'] = Uuid::v4();
		$params['targid'] = $preparedname . '_targid_' . $idfilter;
	
		$params['chids'] = $cilds;
		$params['selected'] = (int)$selected;
        $params['title'] = $title;
		$params['prefLink'] = 'platform.execselectadmin';
        
        $f = array();
        $f['_where']['idfilter'] = $idfilter;
        $f['_where']['status'] = Status::ACTIVE;
		$all = FilterValue::_getAll($f, array('_admin' => '1', '_musttranslate' => 1, '_usecache' => '0'));
		// $all = FilterValue::_getAll($f, array('_admin' => '1', '_musttranslate' => 1));
        
        // if(!count($all)) return view('BaseSite.Empty.empty'); 

        $params['objects'] = $all;

        return  ViewField::make('obj.'. $name)
                    ->view('Orchid.selectGeneral')
                    ->set('params', $params);
	}
}