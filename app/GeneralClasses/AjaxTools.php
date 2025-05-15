<?php

namespace App\GeneralClasses;

use App\Models\Base\BaseModel;

class AjaxTools extends BaseModel
{
    public static $_ajaxCommands = array();

    public static function ProcessInitParams($headers = [])
    {
        $headers = (array) $headers;

        if (count(self::$_ajaxCommands))
        {
            foreach(self::$_ajaxCommands as $v)
            {
                if(!$v['name']) continue;
                $headers = self::AddCommand($v['name'], $v, $headers);
            }
        }
        
        return $headers;
    }

    public static function AddCommand($name, $params = [], $headers = [])
    {
        $headers = (array) $headers;
        $c = (isset($headers['commands'])) ? json_decode($headers['commands'],true) : [];

        $t = (array) $params;
        $t['name'] = $name;

        $c[] = $t;
        $headers['commands'] = json_encode($c);

        return $headers;
    }

}