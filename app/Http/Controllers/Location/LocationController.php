<?php
  
namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order\Order;

class LocationController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new LocationController;
       return self::$MainObj;
    } 


    public function index(Request $request)
    {
        //
    }

    public function execSelectLocation(Request $request){
        return Order::locationselect($request->name, 0,'',$request->idlparent);
    }

}