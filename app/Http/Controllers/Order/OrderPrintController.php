<?php
  
namespace App\Http\Controllers\Order;

use App\Models\Order\Order;
use App\Http\Controllers\Controller;


class OrderPrintController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new OrderPrintController;
       return self::$MainObj;
    } 

    public static function getOrderDetailsPDF($id){
        
        $params['order'] = Order::_get($id, array('_full' => '1', '_musttranslate' => '1'));        
        $params['orderTable'] = self::orderTablePDF($params);
        $params['orderDetailsTable'] = self::orderDetailsTablePDF($params);
        $params['orderProductsTable'] = self::orderProductsTablePDF($params);
        $params['orderJournalTable'] = self::orderJournalTablePDF($params);
        $params['orderMessageTable'] = self::orderMessageTablePDF($params);

        return $params;
    }

    public static function orderTablePDF($params)
    {
        return view('Prints.Template.Order.printOrderTable', ['data' => $params]);
    }

    public static function orderDetailsTablePDF($params)
    {
        return view('Prints.Template.Order.printOrderDetailsTable', ['data' => $params]);
    }

    public static function orderProductsTablePDF($params)
    {
        return view('Prints.Template.Order.printOrderProductsTable', ['data' => $params]);
    }

    public static function orderJournalTablePDF($params)
    {
        return view('Prints.Template.Order.printOrderJournalTable', ['data' => $params]);
    }

    public static function orderMessageTablePDF($params)
    {
        return view('Prints.Template.Order.printOrderMessageTable', ['data' => $params]);
    }

}