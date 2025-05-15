<?php
  
namespace App\Http\Controllers\Page;

use App\GeneralClasses\AjaxTools;
use App\Http\Controllers\Controller;
use App\Models\Base\Slug;
use App\Models\Page\Page;
use Illuminate\Http\Request;
use App\GeneralClasses\SEOTools;
use App\Models\Base\Lang;
use App\Models\Base\Status;
use App\Models\Base\SystemMenu;
use App\Models\Maps\Maps;
use App\Models\Notification\EmailTemplate;
use App\Models\Notification\Notification;
use App\Models\Notification\NotificationAttributes;
use App\Models\Notification\NotificationType;
use Illuminate\Support\Facades\Auth;


class PageController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new PageController;
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

    public function pagePage(Request $request) {
        return $this->pageDetail($request->id);
    }

    protected function pageDetailSetBreadcrumbs($params, $info = []){
        $params['_breadcrumbs'] = [];
        

        $t = new SystemMenu();
        $t->_name =  ($params['obj']) ? $params['obj']->_name : '';
        $t->url = ''; 

        $params['_breadcrumbs'][] = $t;
        
        return $params;
    }

    public function pageDetail($id) {
        $obj = Page::_get($id, array('_full' => true, '_usecache' => '0'));

        if($id == env('IDPAGECONTACT', '39')) {
            return $this->contactsPage($obj);
        }
        
        //===================================================================
        $params = array();
        $params['obj'] = $obj;
        $params =  $this->pageDetailSetBreadcrumbs($params);

        if($obj){
            $this->processSEOInfo($obj);
            
            return $this->GetView('BaseSite.Page.pageDetail', $params);
        }else{

            return Controller::GetObj()->homePage(); 
        }


    }

    public function processSEOInfo($obj){

        SEOTools::$_title = $obj->title_show;
        SEOTools::$_metaKeyWords = $obj->_key_meta_show;
        SEOTools::$_metaDescription = $obj->_description_meta_show;
        SEOTools::$_metaAuthor = $obj->_author_meta_show;
        SEOTools::$_canonical = $obj->url_canonical;

        if($obj->_activeGallery)
        {
            foreach($obj->_activeGallery as $item)
            {
                SEOTools::$_metaImage = $item->url;
            }
        }
    }


    public function contactsPage($obj)
    {   
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;
        $coordinates = Maps::_getAll($f, array('_full' => '1', '_musttranslate' => 1, '_usecache' => '0'));


        $mapParams = [];
        $mapParams['objects'] = $coordinates;
        $mapParams['mapZoom'] = 12;

        if($coordinates['0']){
            $mapParams['mapLat'] = $coordinates['0']->lat;
            $mapParams['mapLng'] = $coordinates['0']->lng;
        }else{
            $mapParams['mapLat'] = 3;
            $mapParams['mapLng'] = 2;
        }

        $params = array();
        $params['Maps'] = view('BaseSite.Contacts.googleMaps', $mapParams);
        $params['Formular'] = $this->contactsForm();
        $params['obj'] = $obj;
        $params =  $this->pageDetailSetBreadcrumbs($params);

        return $this->GetView('BaseSite.Contacts.pageContact', $params);
    }


    public function contactsForm()
    {
        $params = array();

        return view('BaseSite.Contacts.contactFormular', $params);
    }

    public function commandForm(Request $request)
    {
		$params = array();

        return $this->GetView('BaseSite.Notification.commandFormular', $params);
    }

	public function execContactsForm()
	{
		$obj = new Notification();
		$obj->type = NotificationType::COMMAND_FORM;
		$obj->destination = NotificationType::EMAIL;
		if (!$obj->idlang) $obj->idlang = Lang::_getSessionId();
		if (!$obj->priority) $obj->priority = NotificationType::getpriority($obj->type);
		$obj->status = Status::_NEW;	
		$obj->idtemplate = EmailTemplate::getIdFromIdentifier('commandform');
		$obj->parentmodel = '';
		$obj->parentmodel = '';

		$obj->_save();

		$params = array();
        $params['_toemail'] = Auth::user()->email;
		$params['##name##'] = request()->get('name');
		$params['##phone##'] = request()->get('phone');
		$params['##email##'] = request()->get('email');
		$params['##message##'] = request()->get('message');


		$params = (array)$params;
		foreach($params as $k => $v)
		{
			$notificationattr = new NotificationAttributes();
			$notificationattr->idnotification = $obj->id;
			$notificationattr->key = $k;
			$notificationattr->value = $v;
			
			$notificationattr->_save();
		}

        return $this->GetViewMessage('BaseSite.Empty.empty');

	}
}