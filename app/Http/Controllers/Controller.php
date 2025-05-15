<?php

namespace App\Http\Controllers;

use App\GeneralClasses\AjaxTools;
use App\Models\Base\Slug;
use Illuminate\Http\Request;
use App\Models\Base\SystemMenu;
use App\GeneralClasses\SEOTools;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Faq\FaqController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\General\TopController;
use App\Http\Controllers\Lang\LangController;
use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Favorite\FavoriteController;
use App\Http\Controllers\Filter\FilterController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Publicity\PublicityController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\SocialMedia\SocialMediaController;
use App\Http\Controllers\SpecialFilter\SpecialFilterController;
use App\Http\Controllers\User\UserMenuController;
use Symfony\Component\Uid\Uuid;

class Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
        if (self::$MainObj) return self::$MainObj;
        self::$MainObj = new Controller;
        return self::$MainObj;
    } 

        
    public function index(Request $request)
    {
        //        
    }

    public function homePage()
    {

        $params = array();
        $params['_HomeBanner'] = PublicityController::GetObj()->getHomeBanner();
        $params['_SpecialFilter'] = SpecialFilterController::GetObj()->homePageSpecialFilter();
        $params['_CategoryList'] = CategoryController::GetObj()->getHomeCategories();
        $params['_BrandList'] = HomeController::GetObj()->homePageBrandList();
        $params['_ProductVisitedList'] = HomeController::GetObj()->homePageProductVisitedList();
        $params['_FaqList'] = FaqController::GetObj()->getFaqs();
        $params['_HomeInfo'] = HomeController::GetObj()->homeInfo();
        $params['_Benefits'] = HomeController::GetObj()->homePageBenefits();
        
        return $this->GetView('BaseSite.BaseViews.homePage', $params);
    }

    public function homePageTestAjax(Request $request)
    {
        $params = array();
        $params['_homeBanner'] = PublicityController::homePublicityParams($request);

        return $this->GetView('BaseSite.BaseViews.testAjax', $params);
    }

    public function generalSlag(Request $request)
    {
        return Slug::prepareSlug($request);
    }

    public function GetPopUp($view, $params = array(), $otherData = array())
    {
        $request = request();

        $params = (array) $params;

        $headers = [];

        $params['_idpopup'] = Uuid::v4();
        $params['_mainParams'] = array();

        $params['_view'] = $view;

        if ($request->query->get('rt') && $request->query->get('rt') == 'ajax') {
            $headers = SEOTools::GetHeadearAjax();
            $headers = AjaxTools::ProcessInitParams($headers);
        }

        $content = view('BaseSite.BaseViews.layouts.popup', $params);

        return response($content)->withHeaders($headers);
    }

    public function GetView($view, $params = array(), $otherData = array())
    {

        $request = request();

        $params = (array)$params;
        $headers = [];
        $params['_mainParams'] = array();
        $params['_mainParams']['_breadcrumb'] = $this->breadcrumb($request, $params);
        $params['_mainParams']['_headParams'] = SEOTools::GetHeadParams();
        $params['_mainParams']['_topContentParams'] = $this->topContentParams($request); // top content site
        $params['_mainParams']['_leftParams'] = $this->leftParams($request, $params);
        $params['_mainParams']['_rightParams'] = $this->rightParams($request);
        $params['_mainParams']['_footerParams'] = $this->footerParams($request);
        $params['_mainParams']['_infosParams'] = $this->infosParams($request, $params);

        $params['_view'] = $view;

        if ($request->query->get('rt') && $request->query->get('rt') == 'ajax') {
            $headers = SEOTools::GetHeadearAjax();
            $headers = AjaxTools::ProcessInitParams($headers);
            $headers = AjaxTools::AddCommand('jscChangeHTML', ['selector' => '#breadcrumb', 'html' => $params['_mainParams']['_breadcrumb']->render()], $headers);
            if ($this->hasLeftParams($params)) {
                $content = view('BaseSite.BaseViews.layouts.ajax_left', $params);
            }else{
                $content = view('BaseSite.BaseViews.layouts.ajax', $params);
            }
        } else {
            if($this->hasLeftParams($params)){
                $content = view('BaseSite.BaseViews.layouts.full_left', $params);
            }else{
                $content = view('BaseSite.BaseViews.layouts.full', $params);
            }
        }


        return response($content)->withHeaders($headers);
    }

    public function GetViewMessage($view, $params = array(), $otherData = array())
    {
        $request = request();

        $params = (array)$params;

        $headers = [];
        
        if ($request->query->get('rt') && $request->query->get('rt') == 'ajax') {
            $headers = SEOTools::GetHeadearAjax();
            $headers = AjaxTools::ProcessInitParams($headers);

            $content = view($view, $params);

            return response($content)->withHeaders($headers);
        } else
        {
            return view($view, $params);
        }

    }

    protected function hasLeftParams($params)
    {
        if (!is_array($params))
            return false;

        if (!isset($params['_mainParams']))
            return false;

        if (!is_array($params['_mainParams']))
            return false;

        if (!isset($params['_mainParams']['_leftParams']))
            return false;

        if (!$params['_mainParams']['_leftParams'])
            return false;

        return true;
    }

    protected function breadcrumb(Request $request, $params)
    {

        $items = (isset($params['_breadcrumbs'])) ? $params['_breadcrumbs'] : [];

        if ($items) {
            $t = new SystemMenu();
            $t->_name = _GL('Home Page');
            $t->url = route('web.index');

            array_unshift($items, $t);

            return view('BaseSite.BaseViews.partials.Breadcrumb.breadcrumb', array('objects' => $items));
        } else {
            return view('BaseSite.Empty.empty');
        }
    }

    protected function infosParams(Request $request, $params)
    {
        $params = array();

        if (!is_array($params)) return false;
        if (!isset($params['_infosParams'])) return false;

        return view('BaseSite.BaseViews.partials.infos', $params);
    }

    protected function topContentParams(Request $request)
    {
        $params = array();
        $params['_search'] = TopController::GetObj()->searchSection();
        $params['_logoTip'] = TopController::GetObj()->logoTipSection();
        $params['_topContent'] = TopController::GetObj()->topContentSection();
        $params['_socialMedia'] = SocialMediaController::GetObj()->socialMediaTopSection();
        $params['_language'] = LangController::GetObj()->langSection();
        $params['_menuSectionMain'] = MenuController::GetObj()->menuSectionMain();
        $params['_cart'] = OrderController::GetObj()->cartSection();
        $params['_favorite'] = FavoriteController::GetObj()->favoriteSection();
        $params['_login'] = TopController::GetObj()->userIcon();

        return view('BaseSite.BaseViews.partials.header', $params);
    }

    protected function leftParams(Request $request, $infoParams)
    {
        $params = array();
        $params['objects'] = array();


        if(isset($infoParams['left_params']) && isset($infoParams['left_params']['usermenu'])){
            $params['objects'][] = UserMenuController::userMenu();
        }

        if (isset($infoParams['left_params']) && isset($infoParams['left_params']['cateogryFilter'])) {
            $params['objects'][] = $infoParams['left_params']['cateogryFilter'];
        }

        
        if (isset($infoParams['left_params']) && isset($infoParams['left_params']['filters'])) {
            $params['objects'] = array_merge($params['objects'], $infoParams['left_params']['filters']);
        }


        if (!isset($params['objects']) || !count($params['objects'])) {
            return false;
        }

        return view('BaseSite.BaseViews.partials.left', $params);
    }


    protected function rightParams(Request $request)
    {
        $params = array();

        return view('BaseSite.BaseViews.partials.right', $params);
    }

    protected function footerParams(Request $request)
    {
        $params = array();

        $params['_socialMedia'] = SocialMediaController::GetObj()->socialMediaFooterSection();
        $params['_menuSectionBottom'] = MenuController::GetObj()->menuSectionBottom();


        return view('BaseSite.BaseViews.partials.footer', $params);
    }
}
