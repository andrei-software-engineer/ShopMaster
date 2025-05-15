<?php
  
namespace App\Http\Controllers\ProductCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory\ProductCategory;

class ProductCategoryController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new ProductCategoryController;
       return self::$MainObj;
    } 


    public function index(Request $request)
    {
        //
    }

    public function execSelectCategory(Request $request){
        return ProductCategory::locationselect($request->name, 0,'',$request->idlparent);
    }

}