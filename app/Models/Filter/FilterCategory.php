<?php

namespace App\Models\Filter;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use Orchid\Screen\Fields\ViewField;
use Symfony\Component\Uid\Uuid;
use App\Models\Base\BaseModel;
use App\Models\Category\Category;

class FilterCategory extends BaseModel 
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
       self::$MainObj = new FilterCategory;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'filtercategory';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idcategory',
        'idfilter',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idcategory',
        'idfilter',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idcategory',
        'idfilter',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        array('idcategory', 'idfilter'),
    ];

    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {

            $category = Category::_get($obj->idcategory, array('_admin' => '1','_musttranslate' => 1, '_usecache' => '0'));
            $obj->category_name = ($category && $category->_name) ? $category->_name : 'nu exista ';
            $obj->category = $category;
            
            $filter = Filter::_get($obj->idfilter, array('_admin' => '1','_musttranslate' => 1, '_usecache' => '0'));
            $obj->filter_identifier = ($filter && $filter->identifier) ? $filter->identifier : 'nu exista ';
            $obj->filterObj = $filter;
            

            $obj->canDelete = $obj->_canDelete();
        }

        return $obj;
    }

    public function _setParams()
    {
        if (!$this) return;
        $this->_setFilterCategory();
    }

    public function _canDelete()
    {       
        $t =  parent::_canDelete();
        if(!$t){
            return false;
        }
        return true;
    }

    public static function locationselect($name = '', $selected = 0, $cilds = '', $idparent = 0)
	{
        $r = request();
        $params = array();
        $params['chids'] =  $cilds;
        $title = _GLA('Select Category');
		if ($r->get('name')) $name = $r->get('name');
		$idparent = ($r->get('idlparent')) ? (int)$r->get('idlparent') : $idparent;
        
		if (!$name) return view('BaseSite.Empty.empty');

		if ($idparent == -1) 
		{		
			return view('BaseSite.Empty.empty'); 
		}
        
		if ($selected)
		{
			$obj = Category::_get($selected ,array('_admin' => '1', '_musttranslate' => 1));
                        
			if ($obj->idparent)
			{
				$params['name'] = $name;
				$params['id'] = 'id_sel_' . $name;
				$params['targid'] = $name . '_targid_' . $idparent;
	
				$params['chids'] = $cilds;
				$params['selected'] = (int)$selected;
                
				$params['prefLink'] = 'platform.execselectadmin';
				$params['title'] = $title;

                $f = array();
                $f['_where']['idparent'] = $obj->idparent;
                $all = Category::_getAll($f, array('_admin' => '1', '_musttranslate' => 1, '_usecache' => '0'));
                $params['objects'] = $all;
                $cilds = (!count($all)) ? view('BaseSite.Empty.empty')->render() : ViewField::make('obj.' . $name)
                    ->view('Orchid.selectGeneral')
                    ->set('params', $params)->render();
                

                return self::locationselect($name, $obj->idparent, $cilds, 0);
			}
           
		}
		$preparedname = str_replace('[','_',$name);
		$preparedname = str_replace(']','_',$preparedname);
		$params['name'] = $name;
		$params['id'] = Uuid::v4();
		$params['targid'] = $preparedname . '_targid_' . $idparent;
	
		$params['chids'] = $cilds;
		$params['selected'] = (int)$selected;
        $params['title'] = $title;
		$params['prefLink'] = 'platform.execselectadmin';
        
        $f = array();
        $f['_where']['idparent'] = $idparent;
		$all = Category::_getAll($f, array('_admin' => '1', '_musttranslate' => 1, '_usecache' => '0'));
        if(!count($all)) return view('BaseSite.Empty.empty'); 
       
		$params['objects'] = $all;

        return  ViewField::make('obj.'. $name)
                    ->view('Orchid.selectGeneral')
                    ->class('js_CA_select')
                    ->set('params', $params);
	}	
}