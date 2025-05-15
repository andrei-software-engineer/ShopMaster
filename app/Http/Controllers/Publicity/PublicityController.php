<?php
  
namespace App\Http\Controllers\Publicity;

use App\Models\Base\Slug;
use App\Models\Base\Status;
use Illuminate\Http\Request;
use App\Models\Publicity\Publicity;
use App\Http\Controllers\Controller;
  
class PublicityController extends Controller
{
    private static $MainObj = false;

    public static function GetObj()
    {
        if (self::$MainObj) return self::$MainObj;
        self::$MainObj = new PublicityController;
        return self::$MainObj;
    }

    
    public function index(Request $request)
    {
        // 
    }


    // if($obj->startdate_d <= date("Y-m-d") && $obj->enddate_d >= date("Y-m-d"))
    public static function homePublicityParams(Request $request)
    {
        $f = array();
        $f['_where']['advsection'] = Status::ADV_SECTION_TOP;
        $f['_where']['status'] = Status::ACTIVE;
        $f['_between'][] = array('_v' => time(), '_f' => 'startdate', '_t' => 'enddate');

        $objects = Publicity::_getAll($f, array('_full'=> 1, '_words' => 1, '_musttranslate' => 1, '_usecache' => '0'));
        
        $rez = array();
        $rez['objects'] = $objects;

        return $rez;
    }


    public static function getHomeBanner()
    {
        $f = array();
        $f['_where']['advsection'] = Status::ADV_SECTION_TOP;
        $f['_where']['status'] = Status::ACTIVE;
        $f['_between'][] = array('_v' => time(), '_f' => 'startdate', '_t' => 'enddate');

        $objects = Publicity::_getAll($f, array('_full'=> true, '_musttranslate' => 1, '_usecache' => '0'));
        
        $params = array();
        $params['objects'] = [];
        foreach ($objects as $v)
        {
            $params['objects'][] = self::getHomeBannerItem($v)->render();
        }

        $params['_delay'] = (int)_CGC('delay_home_banner');

        return view('BaseSite.Publicity.publicityHome', $params);
    }

    protected static function getHomeBannerItem($obj)
    {
        $params['obj'] = $obj;
        
        return view('BaseSite.Publicity.homeBannerItem', $params);
    }

}