<?php
  
namespace App\Http\Controllers\Notification;

use App\Models\Base\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\Lang;
use App\Models\Notification\EmailTemplate;
use App\Models\Notification\Notification;
use App\Models\Notification\NotificationAttributes;
use App\Models\Notification\NotificationType;

class NotificationController extends Controller
{
    // --------------------------------------------
    public function getNotifications(Request $request)
    {
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;

        $obj = EmailTemplate::_get($request->id, array('_full' => true));

		$rez = array();
		$rez['obj'] = $obj;

        return $this->GetView('BaseSite.Notification.emailTemplateDetails', $rez);
    }


    public function index(Request $request)
    {
		$f = array();
        $f['_where']['status'] = Status::ACTIVE;

        $obj = EmailTemplate::_get($request->id, array('_full' => true));
        
        $rez = array();
        $rez['obj'] = $obj;

        return $this->GetView('BaseSite.Emails.email', $rez);
    }

    public function commandForm(Request $request)
    {
		$params = array();

        return $this->GetView('BaseSite.Notification.commandFormular', $params);
    }

	public function execCommandForm(Request $request)
	{
		// if (!isset(request()->post['email'])) return;
		// request()->post['message'] = nl2br(request()->post['message']);
		
		$obj = new Notification();
		$obj->type = NotificationType::COMMAND_FORM;
		$obj->destination = NotificationType::EMAIL;
		if (!$obj->idlang) $obj->idlang = Lang::_getSessionId();
		if (!$obj->priority) $obj->priority = NotificationType::getpriority($obj->type);
		$obj->status = Status::_NEW;	
		$obj->idtemplate = EmailTemplate::getIdFromIdentifier('commnadform');
		$obj->parentmodel = '';
		$obj->parentmodel = '';

		// $idfile = F::SAVEFILE(request::$FILES['feedbackfile'], 0, 0, 'feedback'.rand().time());
		// if ($idfile)
		// {
		// 	$obj->idfiles = $idfile;
		// 	$obj->deletefiles = '1';
		// }

		$obj->_save();

		$params = array();
		$params['##name##'] = request()->get('fname');
		$params['##name##'] = request()->get('fname');
		$params['##phone##'] = request()->get('phone');
		$params['##email##'] = request()->get('email');
		$params['##message##'] = request()->get('message');
		$params['##replyto##'] = request()->get('replyto');


		$params = (array)$params;
		foreach($params as $k => $v)
		{
			$notificationattr = new NotificationAttributes();
			$notificationattr->idnotification = $obj->id;
			$notificationattr->key = $k;
			$notificationattr->value = $v;
			
			$notificationattr->_save();
		}

		return Controller::GetObj()->homePage();

	}
}

