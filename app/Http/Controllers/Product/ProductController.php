<?php
  
namespace App\Http\Controllers\Product;

use App\GeneralClasses\AjaxTools;
use App\Models\Faq\Faq;
use App\Models\Base\Slug;
use App\Models\Base\Status;
use Illuminate\Http\Request;
use App\Models\Base\Paginate;
use App\Models\Base\SystemMenu;
use App\Models\Product\Product;
use App\Http\Controllers\Controller;
use App\GeneralClasses\ProcessFilter;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Filter\FilterController;
use App\Http\Controllers\Home\HomeController;
use App\Models\Category\Category;

class ProductController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new ProductController;
       return self::$MainObj;
    } 

    public static function checkParentModel(Slug $obj)
    {
        if ($obj->parentmodel != 'product') return false;

        return self::GetObj()->productDetail($obj->parentmodelid);
    }

    public function index(Request $request)
    {
        //
    }

    public function productPage(Request $request) {
        if($request->id){
            return $this->productDetail($request->id);
        }else{
            return Controller::GetObj()->homePage(); 
        }
    }

    protected function pageDetailSetBreadcrumbs($params, $info = []){
        $params['_breadcrumbs'] = [];

        if(request()->get('filter')){
            $p = array();
            $p['filter'] = request()->get('filter');
        }else{
            $p = array();
        }

        $back = new SystemMenu();
        $back->_name =  _GLA('Product List');
        $back->url = route('web.product.list', $p);

        $prd = new SystemMenu();
        $prd->_name =  $params['obj']->_name;
        $prd->url = '';
        
        $params['_breadcrumbs'][] = $back;
        $params['_breadcrumbs'][] = $prd;
        
        return $params;
    }

    public function productDetail($id) {
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;
        $f['_where']['parentmodelid'] = $id;
        $f['_where']['parentmodel'] = 'product';

        $obj = Product::_get($id, array('_admin' => '1','_musttranslate' => 1));
        

        if($obj){
            $responses = Faq::_getAll($f, array('_full' => '1','_withChildren' => 1, '_musttranslate' => 1, '_usecache' => '0'));
    
            $params = array();
            $params['obj'] = $obj;
            $params['obj']['responses'] = $responses;
            $params =  $this->pageDetailSetBreadcrumbs($params);
            $params['_ProductVisitedList'] = HomeController::GetObj()->homePageProductVisitedList();
            return $this->GetView('BaseSite.Product.productDetail', $params);

        }else{
            return Controller::GetObj()->homePage(); 
        }

    }


    protected function productList_LeftPart($params)
    {
        $params['left_params']['cateogryFilter'] = CategoryController::categoryLeftPart($params);
        $params['left_params']['filters'] = FilterController::filtersLeftPart($params);

        return $params;
    }
    
    protected function productList_Breadcrumbs($params, $info = [])
    {
        $params['_breadcrumbs'] = [];

        $categoryparents = (array) $params['categoryparents'];

        $tobj = new SystemMenu();
        $tobj->_name = _GLA('Category');
        $tobj->url = route('web.category', []);
        $params['_breadcrumbs'][] = $tobj;

        foreach ($categoryparents as $v)
        {
            $tobj = new SystemMenu();
            $tobj->_name = $v->_name;
            $tobj->url = $v->url;
            $params['_breadcrumbs'][] = $tobj;
        }

        if ($params['categoryobj'])
        {
            $prd = new SystemMenu();
            $prd->_name = $params['categoryobj']->_name;
            $prd->url = '';
            $params['_breadcrumbs'][] = $prd;
        }

        return $params;
    }

    public function productList()
    {
        return $this->productList_inter();
    }

    public function searchProductList()
    {
        $params = array();
        $params['filter[search]'] = request()->get('filter')['search'];
        AjaxTools::$_ajaxCommands[] = ['name' => 'jscChangeBrowserLocation', 'href' => route('web.product.list', $params)];

        return $this->productList_inter();
    }

    public function productListPage()
    {
        return $this->productListPage_intern();
    }

    protected function processParams($params=[])
    {

        if(array_key_exists('specFilter', $params)){
            $filter = $params['specFilter'];
        }else{
            $filter = request()->get('filter');
        }
        $od = request()->get('od');
        $params['filter'] = ProcessFilter::filterProces($filter, $params);
        $params['od'] = ProcessFilter::otherDataProces($od, $params);
        $params['category'] = ProcessFilter::parseCategory($filter, $params);
        $params['page'] = ProcessFilter::pageProces($filter, $params);

        return $params;
    }

    public function productList_inter($params=[])
    {
        $params = $this->processParams($params);
        
        $params = $this->productList_LeftPart($params);
        $params = $this->productList_Breadcrumbs($params);

        return $this->productpage_list($params);
    }

    public function productListPage_intern($params=[])
    {
        $params = $this->processParams($params);

        return $this->productpage_page($params, false);
    }

    protected function productpage_list($params)
    {
        $params['head'] = $this->productpage_head($params)->render();
        $params['headCategory'] = $this->productpage_head_category($params)->render();
        $params['footer'] = $this->productpage_footer($params)->render();
        $params['page'] = $this->productpage_page($params)->render();

        return $this->GetView('BaseSite.Product.productList', $params);
    }

    protected function productpage_head($p)
    {
        $params = [];
        $params['obj'] = (isset($p['categoryobj']) && $p['categoryobj']) ? $p['categoryobj'] : false;

        $params['op'] = (isset($p['od']) && isset($p['od']['op'])) ? $p['od']['op'] : 10;
        $params['opvals'] = [8,16,24,32,40];

        $params['o'] = (isset($p['od']) && isset($p['od']['o'])) ? $p['od']['o'] : Status::ORDER_BY_NAME_ASC;
        $params['orderbyvals'] = Status::GA('product_order_by');

        $params['ourlparams'] = ProcessFilter::getUrlPatrams($p, ['o', 'page']);
        $params['opurlparams'] = ProcessFilter::getUrlPatrams($p, ['op', 'page']);

        return view('BaseSite.Product.productpage_head', $params);
    }

    protected function productpage_head_category($p)
    {
        $f = array();
        $params = array();

        if(!$p['categoryobj']){
            // $f['_where']['idparent'] = (int)\config('app.allegro_first_category_localid');
            $f['_where']['status'] = Status::ACTIVE;
    
            $objects = Category::_getAll($f, array('_full' => '1', '_musttranslate' => 1, '_usecache' => '0'));

            $params['objects'] = [];
            foreach ($objects as $v) {
                $params['objects'][] = $this->getHomeCategoriesItem($v)->render();
            }
            return view('BaseSite.Product.CategoryHead.productpage_head_category', $params);

        }else{

            $f['_where']['idparent'] = $p['categoryobj']->id;
            $f['_where']['status'] = Status::ACTIVE;
    
            $objects = Category::_getAll($f, array('_full' => '1', '_musttranslate' => 1, '_usecache' => '0'));
    
            $params['objects'] = [];
            foreach ($objects as $v) {
                $params['objects'][] = $this->getHomeCategoriesItem($v)->render();
            }
    
            return view('BaseSite.Product.CategoryHead.productpage_head_category', $params);
        }
    }

    protected static function getHomeCategoriesItem($obj)
    {
        $params['obj'] = $obj;

        return view('BaseSite.Product.CategoryHead.productpage_head_category_item', $params);
    }

    protected function productpage_footer($p)
    {
        if (!isset($p['categoryobj']) || !$p['categoryobj'])
            return view('BaseSite.Empty.empty', []);

        $params = [];
        $params['obj'] = $p['categoryobj'];
        
        return view('BaseSite.Product.productpage_footer', $params);
    }

    protected function productpage_page($params, $view = true)
    {

        $f = [];
        $f['_where']['status'] = Status::ACTIVE;


        //  cind te duci din search bar
        if(array_key_exists('search',$params['filter'])){
            $search = '%'. reset($params['filter']['search']) .'%';

            $f['_where']['tpw.value'] = ['_act' => 'LIKE', $search];
            $f['_leftJoin'][] = ['_tb' => 'product_word', '_alias' => 'tpw', '_fromc' => 'id', '_toc' => 'idparent'];

        }
        
        // //  cind selectezi un filtru
        foreach ($params['filter'] as $k => $v)
        {
            if ($k == 'search') continue;
            if ($k == 'idcategory') continue;
            if (!$k) continue;
            if (!$v) continue;

            $f['_leftJoin'][] = ['_tb' => 'filterproduct', '_alias' => 'fp_'.$k, '_fromc' => 'id', '_toc' => 'idproduct'];
            $f['_where']['fp_' . $k . '.idfilter'] = $k;
            $f['_where']['fp_' . $k . '.idfiltervalue'] = $v;
        }   

        //  cind apesi pe o categorie
        if ($params['category'])
        {
            $f['_leftJoin'][] = ['_tb' => 'product_category', '_alias' => 'pc', '_fromc' => 'id', '_toc' => 'idproduct'];
            $f['_where']['pc.idcategory'] = $params['category']->id;
        }

        // cind te duci din filtru
        if (array_key_exists('idcategory',$params['filter']))
        {
            $f['_leftJoin'][] = ['_tb' => 'product_category', '_alias' => 'pc', '_fromc' => 'id', '_toc' => 'idproduct'];
            $f['_where']['pc.idcategory'] = reset($params['filter']['idcategory']);
        }

        
        $total = Product::_getCount($f);

        $procesedPage = Paginate::getParams(request(), $total, $params);
        $f['_start'] = $procesedPage->start;
        $f['_limit'] = $procesedPage->limit;

        $objects = Product::_getAll($f, array('_full' => '1',  '_musttranslate' => 1, '_usecache' => '0'));

        $params['objects'] = [];
        foreach ($objects as $v)
        {
            $params['objects'][] = $this->productListTemplate($v)->render();
        }


        $pageParams = ProcessFilter::getUrlPatrams($params, ['page']);

        $urlprefix = route('web.product.listpage',$pageParams);
        $urlprefix .=  (count($pageParams)) ? '&' : '?';
        $urlprefix .=  'page=';
        $urlsufix = '';
        $params['paginate'] = Paginate::getPaginateHtml($procesedPage->currPag, $procesedPage->totalpag, $urlprefix, $urlsufix, 'js_al', 'product_page');

        if ($view)
        {
            return view('BaseSite.Product.productPage', $params);
        }

        $newParams = $pageParams;
        if ($procesedPage->currPag > 1)
            $newParams['page'] = $procesedPage->currPag;

        return $this->GetViewMessage('BaseSite.Product.productPage', $params);
    }

    protected function productListTemplate($obj)
    {
        $params['obj'] = $obj;

        return view('BaseSite.Product.productItem', $params);
    }


}
