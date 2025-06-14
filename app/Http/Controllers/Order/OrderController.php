<?php
  
namespace App\Http\Controllers\Order;

use App\GeneralClasses\AjaxTools;
use Carbon\Carbon;
use App\Models\Order\Order;
use App\Models\Order\CartOrder;
use App\Models\Order\OrderForm;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Profile\ProfileController;
use App\Models\Base\Paginate;
use App\Models\Base\Status;
use App\Models\Base\SystemFile;
use App\Models\Base\SystemMenu;
use App\Models\InfoUser\InfoUser;
use App\Models\Order\OrderMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new OrderController;
       return self::$MainObj;
    } 

    public function checkout()
    {


        $user = Auth::user();
        $infoUser = InfoUser::query()->where('iduser', $user->id)->first();
        // dd($user->id);

		$params = array();
        $params['products'] = Order::getProducts();
        $params['mod_livrare'] = Status::GA('order_delivery_method');
        $params['mod_achitare'] = Status::GA('order_paymethod');
        $params['livrare'] = Order::locationselect('destinatar_idlocation', 0, '', 0);
        $params['user'] = $user;
        $params['infoUser'] = $infoUser;
        $params['left_params']['usermenu'] = [];

        $total = ($params['products']) ? count($params['products']) : 0;

        $procesedPage = Paginate::getParams(request(), $total);

        $urlprefix = route('web.product.listpage');
        $urlprefix .=  '?page=';
        $urlsufix = '';
        $params['paginate'] = Paginate::getPaginateHtml($procesedPage->currPag, $procesedPage->totalpag, $urlprefix, $urlsufix, 'js_al', 'product_page');

        $params = $this->pageDetailSetBreadcrumbsProfile($params);

        return $this->GetView('BaseSite.Order.checkout', $params);
    }

    public function execCheckout(Request $request)
	{
        $order = OrderForm::createOrder();

        $cartItems = request()->session()->all();
        if($cartItems['cart'])
        {        
            foreach($cartItems['cart'] as $item){
                OrderForm::saveOrderProducts($order, $item['idproduct'], $item['quantity']);
            }
        } 

        CartOrder::clean();

        return redirect()->route('web.paymentcheckpage', $order->id);
	}


    public function saveQuantity()
    {
        $idproduct = request()->get('idproduct');
        $quantity = request()->get('quantity');
        CartOrder::add($idproduct, $quantity);

        return $this->GetViewMessage('BaseSite.Empty.empty');
    }


    public function saveOrderMessage(Request $request)
	{
        $params = array();
        $order = Order::_get($request->get('idorder'));

        if(!$order) return ProfileController::GetObj()->profile($request, ''); 
        
        $obj = new OrderMessage();

        if($order->iduser == Auth::user()->id)
        {
            $obj->idorder = $order->id;
            $obj->visibilitytype = Status::USER;
            $obj->ordermessagetype = Status::USER;
            $obj->data = Carbon::now()->getTimestamp();
            $obj->message = $request->get('message');
            if($request->file()) $obj->idfile = SystemFile::saveFiles($request->file()['fileX']) ;

            $obj->_save();
        }
        $order = Order::_get($request->get('idorder'), array('_full' => '1','_musttranslate' => 1));

        $params['order'] = $order;
        return $this->GetView('BaseSite.Order.OrderDetails.orderMessageTable', $params);
    }


    public function cartSection()
	{        
        $params = array();

        $params['cartItems'] = Order::getCartItems();

        return view('BaseSite.Order.cartButton', $params);
    }

    protected function pageDetailSetBreadcrumbsProfile($params, $info = []){
        $params['_breadcrumbs'] = [];

        $prd = new SystemMenu();
        $prd->_name =  _GL('Checkout_brd');
        $prd->url = '';
        
        $params['_breadcrumbs'][] = $prd;
        
        return $params;
    }
}