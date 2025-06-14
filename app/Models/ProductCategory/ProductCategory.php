<?php

namespace App\Models\ProductCategory;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\Status;
use App\Models\Category\Category;
use App\Models\Faq\FaqResponses;
use App\Models\Product\Product;
use Orchid\Screen\Fields\ViewField;
use Symfony\Component\Uid\Uuid;

class ProductCategory extends BaseModel 
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
       self::$MainObj = new ProductCategory;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'product_category';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idcategory',
        'idproduct',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idcategory',
        'idproduct',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idcategory',
        'idproduct',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        array('idcategory', 'idproduct'),
    ];


    public  function processObject($obj, $params)
    {
        $params = (array)$params;
        
        $obj = parent::processObject($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {



            $category = Category::_get($this->idcategory, array('_admin' => '1','_musttranslate' => 1));
            $obj->category_name = ($category && $category->_name) ? $category->_name : 'nu exista ';
            $obj->category = $category;
            
            $product = Product::_get($this->idproduct, array('_admin' => '1' ,'_musttranslate' => 1));
            $obj->product_name = ($product && $product->_name) ? $product->_name : 'nu exista ';
            $obj->product = $product;

            if (!$obj->categoryObj)
                $obj->categoryObj = new Category();
            if (!$obj->productObj)
                $obj->productObj = new Product();

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

    public function _setParams()
    {
        if (!$this) return;
        $this->_setFilterCategory();
    }

    public static function locationselect($name = '', $selected = 0, $cilds = '', $idparent = 0)
	{
        $r = request();
        $params = array();
        $params['chids'] =  $cilds;
        $title = _GLA("Select Category");

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
                $params['title'] = $title;
                
				$params['prefLink'] = 'platform.execselectadmin';

                $f = array();
                $f['_where']['idparent'] = $obj->idparent;
                $all = Category::_getAll($f, array('_admin' => '1', '_musttranslate' => 1));
                $params['objects'] = $all;
                dd($params);
                $cilds = (!count($all)) ? view('BaseSite.Empty.empty')->render() : ViewField::make('obj.' . $name)
                    ->view('Orchid.selectGeneral')
                    ->title('Select category')
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
                    ->title('Select category')
                    ->set('params', $params);
	}	
}