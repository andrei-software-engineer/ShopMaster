<?php
  
namespace App\Models\Order;

use App\Models\Base\BaseModel;


class Delivery extends BaseModel 
{
    const CURIER = 1;
    const POSTA = 2;

    public static function GA()
    {
        $rez = [];
        $rez[self::CURIER] = 'CURIER';
        $rez[self::POSTA] = 'POSTA';

        return $rez;
    }
}