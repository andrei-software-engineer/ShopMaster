<?php

namespace App\Http\Controllers\User;

use App\GeneralClasses\AjaxTools;
use App\Models\User;
use App\Models\Base\Lang;
use App\Models\Base\Status;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Base\Exceptions;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Orchid\Support\Facades\Dashboard;
use Illuminate\Support\Facades\Validator;
use App\Models\Notification\Notification;
use App\Models\Notification\EmailTemplate;
use App\Models\Notification\NotificationType;
use App\Models\Notification\NotificationAttributes;

class UserCredentialsController extends Controller
{

    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
        if (self::$MainObj) return self::$MainObj;
        self::$MainObj = new UserCredentialsController;
        return self::$MainObj;
    } 


    public function index(Request $request)
    {
        //
    }

    public function signUp(Request $request)
    {
        $params = array();

        AjaxTools::$_ajaxCommands[] = ['name' => 'jscChangeHTML', 'selector' => '#messageresult', 'html' => ''];

        return $this->GetView('BaseSite.User.signUp', $params);
    }


    public function execSignUp(Request $request)
    {
        $data = array();
        $data['name'] = request()->get('name');
        $data['email'] = request()->get('email');
        $data['password'] = request()->get('password');

        Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'permissions' => Dashboard::getAllowAllPermission(),
        ]);

        return UserCredentialsController::GetObj()->signIn($request); 
    }


    public function signIn($infos = null)
    {
        $params = array();
        $params['_infosParams'] = '';
        if($infos) $params['_infosParams'] = $infos;

        return $this->GetView('BaseSite.User.signIn', $params);
    }

    public function execSignIn(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate(); 
            
            
            return ProfileController::GetObj()->profile($request);
        }

        $infos = Exceptions::errorNotFoundHTML(_GL('Incercati din nou'));

        return $this->signIn($infos);
    }


    public function resetPassword(Request $request)
    {
        $params = array();

        return $this->GetView('BaseSite.User.resetPassword', $params);
    }

    
    public function execResetPassword(Request $request)
    {
        $data = array();
        $data['email'] = request()->get('email');
        $data['new_password'] = request()->get('new_password');
        $data['confirm_new_password'] = request()->get('confirm_new_password');

        $user = User::query()->where('email', $request->email)->first();


        if (!$user) {
            return Exceptions::errorNotFoundHTML(_GL('Nu este corect adresa de email'));
        }

        if ($user->hash_token == $request->_uid) {

            $request->validate([
                'email' => 'required|email|exists:users',
                'new_password' => 'required',
                'confirm_new_password' => 'required'
            ]);

            DB::table('password_resets')->where([
                'email' => $request->email,
                'token' => $request->token
            ])->first();


            User::where('email', $request->email)->update(['password' => Hash::make($data['new_password'])]);

            return ProfileController::GetObj()->profile($request);
        }
    }

    public function checkPassword(Request $request)
    {
        $params = array();

        return $this->GetView('BaseSite.User.checkPassword', $params);
    }

    public function execCheckPassword(Request $request)
    {
        $user = User::query()->where('email', $request->email)->first();

        if (!$user) {
            return Exceptions::errorNotFoundHTML(_GL('Nu este corect adresa de email'));
        }

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
        $params['##reseturl##'] = route('web.resetPassword') . '?uid=' . $hash_token;
        $params['##email##'] = $user->email;

        $params = (array) $params;
        foreach ($params as $k => $v) {
            $notificationattr = new NotificationAttributes();
            $notificationattr->idnotification = $obj->id;
            $notificationattr->key = $k;
            $notificationattr->value = $v;

            $notificationattr->_save();
        }

        return ProfileController::GetObj()->profile($request);

    }
}
