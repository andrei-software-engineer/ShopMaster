<?php

namespace App\Http\Controllers\Mail;


use Illuminate\Support\Str;
use App\Models\Base\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\Lang;
use App\Models\Notification\FromEmail;
use App\Models\Notification\Notification;
use App\Models\Notification\EmailTemplate;
use App\Models\Notification\NotificationAttributes;
use App\Models\Notification\NotificationType;

use App\Models\Notification\PreparedEmail;

class MailController extends Controller
{

    public function index(Request $request)
    {
        $this->emailTemplate();
        
        return Controller::GetObj()->homePage(); 
    }

    public function emailTemplate()
    {
        $f = array();
        $f['_where'] = array();
        $f['_where']['destination'] = NotificationType::EMAIL;
        $f['_where']['status'] = Status::_NEW;

        $notification = Notification::_getAll($f, ['_full' => '1', '_musttranslate' => 1, '_usecache' => '0']);

        foreach ($notification as $item) {
            $this->processNotificationItem($item);
        }
        
    }

    public function processNotificationItem($item)
    {
        $notificationAttributes = NotificationAttributes::_getAll(array('_where' => array('idnotification' => $item->id)), ['_full' => '1']);
        $emailTemplate = EmailTemplate::_get($item->idtemplate, ['_full' => '1']);
        $fromEmail = FromEmail::_get($emailTemplate->idfromemail, ['_full' => '1']);

        // -------
        $obj = new PreparedEmail();
        $obj->setGeneralData($emailTemplate, $notificationAttributes, $fromEmail);

        $obj->_send();
        $item->_delete();

        return $obj;
    }

    public static function validateEmail($user)
    {
        $hash_token = Str::uuid()->toString();
        $user->hash_token = $hash_token;
        $user->save();

        $obj = new Notification();
        $obj->type = NotificationType::RESET_PASS;
        $obj->destination = NotificationType::EMAIL;
        if (!$obj->idlang) $obj->idlang = Lang::_getSessionId();
        if (!$obj->priority) $obj->priority = NotificationType::getpriority($obj->type);
        $obj->status = Status::_NEW;
        $obj->idtemplate = EmailTemplate::getIdFromIdentifier('reset_password');
        $obj->parentmodel = '';
        $obj->_save();

        $params = array();
        $params['_toemail'] = $user->email;
        $params['##resetcode##'] = $hash_token;
        $params['##reseturl##'] = route('web.validateEmail').'?uid='.$hash_token.'?email='.urlencode($user->email);
        $params['##email##'] = $user->email;

        $params = (array) $params;
        foreach ($params as $k => $v) {
            $notificationattr = new NotificationAttributes();
            $notificationattr->idnotification = $obj->id;
            $notificationattr->key = $k;
            $notificationattr->value = $v;

            $notificationattr->_save();
        }

    }

}