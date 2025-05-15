<?php
  
namespace App\Http\Controllers\Order;

use App\GeneralClasses\AjaxTools;
use App\Models\Order\CartOrder;
use App\Http\Controllers\Controller;
use App\Models\Favorite\Favorite;
use App\Models\Order\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class CartController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new CartController;
       return self::$MainObj;
    } 

    
    public function checkIdUser(){
        if(!Auth::check()){
            $favorites = '';
        }else{
            $q = array();
            $q['_where']['iduser'] = 1;
            $q['_limit'] = 20;
            $favorites = Favorite::_getAll($q, array('_full' => '1' , '_musttranslate' => 1));
        }
        
        return $favorites;
    }

    public function addCart(Request $request)
    {
        $idproduct = request()->get('idproduct');
        $quantity = request()->get('quantity');
       
        CartOrder::add($idproduct, $quantity );

        AjaxTools::$_ajaxCommands[] = ['name' => 'jscAddClass', 'selector' => '#idformaddbtnlistitem_' . $idproduct, 'class' => 'fav-active'];
        AjaxTools::$_ajaxCommands[] = ['name' => 'jscRemClass', 'selector' => '#idformaddbtnlistitem_' . $idproduct, 'class' => 'fav-inactive'];
        AjaxTools::$_ajaxCommands[] = ['name' => 'jscChangeHTML', 'selector' => '#idcartitems', 'html' => Order::getCartItems()];


        return $this->GetViewMessage('BaseSite.Empty.empty');

    }


    public function deleteCart()
    {
        $idproduct = request()->get('idproduct');

        CartOrder::__delete($idproduct);

        AjaxTools::$_ajaxCommands[] = ['name' => 'jscAddClass', 'selector' => '#idformbtnlistitem_' . $idproduct, 'class' => 'fav-inactive'];
        AjaxTools::$_ajaxCommands[] = ['name' => 'jscRemClass', 'selector' => '#idformbtnlistitem_' . $idproduct, 'class' => 'fav-active'];
        AjaxTools::$_ajaxCommands[] = ['name' => 'jscRemove', 'selector' => '#idproductlistitem_' . $idproduct];
        AjaxTools::$_ajaxCommands[] = ['name' => 'jscChangeHTML', 'selector' => '#idcartitems', 'html' => Order::getCartItems()];

        return $this->GetViewMessage('BaseSite.Empty.empty');
    }

    public function cleanCart(Request $request)
    {
        CartOrder::clean();

        return OrderController::GetObj()->checkout(); 
    }
}