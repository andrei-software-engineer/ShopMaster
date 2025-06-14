<?php
  
namespace App\Http\Controllers\Favorite;

use App\GeneralClasses\AjaxTools;
use App\Models\Favorite\Favorite;
use App\Http\Controllers\Controller;
use App\Models\Base\Paginate;
use App\Models\Base\SystemMenu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class FavoriteController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new FavoriteController;
       return self::$MainObj;
    } 

    public function addFavorite(Request $request)
    {
        if(!Auth::check()){
            $params = [];
            $otherData = [];
            return $this->GetPopUp('BaseSite.Empty.empty', $params, $otherData);
        }else{
            $idproduct = request()->get('idproduct');
            $iduser = Auth::user()->id;
    
            $f = array();
            $f['_where']['iduser'] = $iduser;
            $f['_where']['idproduct'] = $idproduct;
            $favorites = Favorite::_getAll($f, array('_full' => '1' ,'_musttranslate' => '1'));
    
            if (count($favorites))
            {
                $item = reset($favorites);
                $item->delete();
    
                AjaxTools::$_ajaxCommands[] = ['name' => 'jscAddClass', 'selector' => '#idfavbtlist_' . $idproduct, 'class' => 'fav-inactive'];
                AjaxTools::$_ajaxCommands[] = ['name' => 'jscRemClass', 'selector' => '#idfavbtlist_' . $idproduct, 'class' => 'fav-active'];
                AjaxTools::$_ajaxCommands[] = ['name' => 'jscRemove', 'selector' => '#idfavlistitem_' . $idproduct];
                AjaxTools::$_ajaxCommands[] = ['name' => 'jscChangeHTML', 'selector' => '#idfavitelist', 'html' => collect($this->checkIdUser())->count()];
            } else{
                $obj = new Favorite();
                $obj->idproduct = $idproduct;
                $obj->iduser = $iduser;
                $obj->add_date = time();
    
                $obj->_save();
                $obj->isInFavorite = true;
    
                AjaxTools::$_ajaxCommands[] = ['name' => 'jscAddClass', 'selector' => '#idfavbtlist_' . $idproduct, 'class' => 'fav-active'];
                AjaxTools::$_ajaxCommands[] = ['name' => 'jscRemClass', 'selector' => '#idfavbtlist_' . $idproduct, 'class' => 'fav-inactive'];
                AjaxTools::$_ajaxCommands[] = ['name' => 'jscChangeHTML', 'selector' => '#idfavitelist', 'html' => collect($this->checkIdUser())->count()];
            }
    
            return $this->GetViewMessage('BaseSite.Empty.empty');
        }
    }

    public function checkIdUser(){
        if(!Auth::check()){
            $favorites = '';
        }else{
            $q = array();
            $q['_where']['iduser'] = 1;
            $q['_limit'] = 20;
            $favorites = Favorite::_getAll($q, array('_full' => '1' ,'_musttranslate' => '1'));
        }
        
        return $favorites;
    }

    public function favoriteSection()
	{        
        $params = array();

        if(collect($this->checkIdUser())->count() == 0){
            $params['objects'] = '';
        }else{
            $params['objects'] = collect($this->checkIdUser())->count();
        }

        return view('BaseSite.Favorite.favoriteButton', $params);
    }


    
    public function favorite()
	{        
        $params = array();

        $f = array();
        if(!Auth::check()){
            $favorites = '';
        }else{
            if(isset(Auth::user()->id)){
                $f['_where']['iduser'] = Auth::user()->id;
            }else{
                return view('BaseSite.Empty.empty');
            }

            $total = Favorite::_getCount($f);
            $procesedPage = Paginate::getParams(request(), $total);
            $f['_start'] = $procesedPage->start;
            $f['_limit'] = $procesedPage->limit;
            $urlprefix = route('web.favorite').'?page=';
            $urlsufix = '';
    
            $favorites = Favorite::_getAll($f, array('_full' => '1' ,'_musttranslate' => '1'));

        }        
           
        $params['left_params']['usermenu'] = [];
        $params['obj']['favorite'] = $favorites;
        $params['obj']['paginate'] = Paginate::getPaginateHtml($procesedPage->currPag, $procesedPage->totalpag, $urlprefix, $urlsufix, 'js_al');

        $params = $this->pageDetailSetBreadcrumbsProfile($params);

        return $this->GetView('BaseSite.Favorite.favorite', $params);
    }

    protected function pageDetailSetBreadcrumbsProfile($params, $info = []){
        $params['_breadcrumbs'] = [];

        $prd = new SystemMenu();
        $prd->_name =  _GL('Favorite');
        $prd->url = '';
        
        $params['_breadcrumbs'][] = $prd;
        
        return $params;
    }

}