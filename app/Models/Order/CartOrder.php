<?php

namespace App\Models\Order;

use App\Models\Base\BaseModel;

class CartOrder extends BaseModel 
{

    public static function add($idproduct, $quantity)
    {
        $arr = ['idproduct' => $idproduct, 'quantity' => $quantity];
        $cartItems = request()->session()->all();
        $cartItems = (isset($cartItems['cart'])) ? $cartItems['cart'] : [];

        $cartItems = array_filter($cartItems, function ($v, $k) use ($idproduct) {
            if (!isset($v['idproduct'])) return false;
            if ($v['idproduct'] == $idproduct) return false;
            return true;
        }, ARRAY_FILTER_USE_BOTH);

        $cartItems[] = $arr;
        session()->put('cart', $cartItems);
    }

    public static function __delete($idproduct)
    {
        $cartItems = request()->session()->all();
        $cartItems = (isset($cartItems['cart'])) ? $cartItems['cart'] : [];

        $cartItems = array_filter($cartItems, function ($v, $k) use ($idproduct) {
            if (!isset($v['idproduct']))
                return false;
            if ($v['idproduct'] == $idproduct)
                return false;
            return true;
        }, ARRAY_FILTER_USE_BOTH);

        session()->put('cart', $cartItems);
    }

    public static function clean()
    {
        session()->put('cart', []);
    }
}