<?php
  
namespace App\Http\Controllers\Faq;

use App\Http\Controllers\Controller;
use App\Models\Base\Slug;
use App\Models\Base\Status;
use App\Models\Faq\Faq;
use Illuminate\Http\Request;
  
class FaqController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new FaqController;
       return self::$MainObj;
    } 

    public static function checkParentModel(Slug $obj)
    {
        if ($obj->parentmodel != 'page') return false;
        return self::GetObj()->pageDetail($obj->parentmodelid);
    }


    public function index(Request $request)
    {
        //
    }


    public function fncPage() {
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;
        
        $objects = Faq::_getAll($f, array('_full'=> 1 ,'_musttranslate' => '1', '_usecache' => '0', '_withChildren' => 1));

        $rez = array();
        $rez['level'] = '1';
        $rez['objects'] = $objects;

        return $this->GetView('BaseSite.Faq.faq', $rez);
    }


    public static function GetFAQ($parent, $id){
        $f = array();
        $f['_where']['parentmodel'] = $parent;
        $f['_where']['parentmodelid'] = $id;
        
        $obj = Faq::_getAll($f, array('_full'=> 1 ,'_musttranslate' => '1', '_usecache' => '0',  '_withChildren' => 1));

        return view('BaseSite.Faq.faq', ['objects' => $obj]);
    }

    public function getFaqs() {
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;
        
        $objects = Faq::_getAll($f, array('_full'=> 1 ,'_musttranslate' => '1', '_usecache' => '0',  '_withChildren' => '1'));

        $rez = array();
        $rez['faqs'] = $objects;

        return view('BaseSite.Faq.faqContent', $rez);
    }
}