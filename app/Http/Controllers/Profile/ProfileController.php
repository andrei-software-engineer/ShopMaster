<?php
  
namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Base\Exceptions;
use App\Models\InfoUser\InfoUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Base\SystemMenu;
use App\Http\Controllers\Mail\MailController;
use App\Http\Controllers\User\UserCredentialsController;

class ProfileController extends Controller
{

    // --------------------------------------------
    private static $MainObj = false;


    public static function GetObj()
    {
        if (self::$MainObj)
            return self::$MainObj;
        self::$MainObj = new ProfileController;
        return self::$MainObj;
    }


    public function index(Request $request)
    {
        //
    }

    
    protected function pageDetailSetBreadcrumbsProfile($params, $info = []){
        $params['_breadcrumbs'] = [];

        $prd = new SystemMenu();
        $prd->_name =  _GL('Profile');
        $prd->url = '';
        
        $params['_breadcrumbs'][] = $prd;
        
        return $params;
    }


    public function profile(Request $request, $infos = false)
    {
        $user = User::query()->where('id', Auth::user()->id)->first();
        $userInfo = InfoUser::query()->where('iduser', Auth::user()->id)->first();
        $params = array();

        if($user){
            if($userInfo){
                $params['user'] = $userInfo;
                $params['userEmail'] = $user->email;
            }else{
                $params['user'] = InfoUser::defaultParams();
                $params['userEmail'] = '';
            }
        }
       
        $params['_infosParams'] = '';
        if($infos) $params['_infosParams'] = $infos;
        $params['left_params']['usermenu'] = [];
        
        $params = $this->pageDetailSetBreadcrumbsProfile($params);

        return $this->GetView('BaseSite.Profile.profile', $params);
    }

    protected function canUseNewEmail($email, $userId)
    {
        $other = User::query()->where('email', $email)->whereNot('id', $userId)->first();

        if ($other)
            return false;

        return true;
    }

    public function execProfile(Request $request)
    {
        $user = User::query()->where('id', Auth::user()->id)->first();


        if (!$user) 
        {
            $infos = Exceptions::errorNotFoundHTML(_GL('User not found'));
            return $this->profile($request, $infos);
        }
        // --------------------------------

        if (!$this->canUseNewEmail(request()->get('email'), $user->id))
        {
            $infos = Exceptions::errorNotFoundHTML(_GL('Email address used !'));
            return $this->profile($request, $infos);
        }
        // -------------------------------

        // -------------------------------
        if (request()->get('email') != $user->email)
        {
            $user->email = request()->get('email');
            $user->hash_token = Str::uuid()->toString();;
            $user->save();

            MailController::validateEmail($user);
        }
        // -------------------------------

        $userInfo = InfoUser::query()->where('iduser', $user->id)->first();

        if (!$userInfo) {
            
            $userInfo = InfoUser::GetObj();
            $userInfo->iduser = $user->id;
        }

        $userInfo->nume = request()->get('nume');
        $userInfo->prenume = request()->get('prenume');
        $userInfo->email = request()->get('email');
        $userInfo->phone = request()->get('phone');
        $userInfo->mobil = request()->get('mobil');

        if(!is_numeric($userInfo->phone) || !is_numeric($userInfo->mobil)){
            $infos = Exceptions::errorNotFoundHTML(_GL('Phone and mobil must contain only digits !'));
            return $this->profile($request, $infos);
        }

        $userInfo->_save();

        $infos = Exceptions::errorNotFoundHTML(_GL('Profile saved'));
        return $this->profile($request, $infos);
    }

    public function redirectProfile(Request $request)
    {
        return ProfileController::GetObj()->profile($request);
    }


    protected function pageDetailSetBreadcrumbsSettings($params, $info = []){
        $params['_breadcrumbs'] = [];

        $prd = new SystemMenu();
        $prd->_name =  _GL('Settings');
        $prd->url = '';
        
        $params['_breadcrumbs'][] = $prd;
        
        return $params;
    }

    public function settings(Request $request, $infos = false)
    {
        $params = array();
        $params['_infosParams'] = [];
        if($infos) $params['_infosParams'] = $infos;
        $params['left_params']['usermenu'] = [];
        $params = $this->pageDetailSetBreadcrumbsSettings($params);

        return $this->GetView('BaseSite.Profile.settings', $params);
    }

    public function execSettings(Request $request)
    {
        $data = array();
        $data['current_password'] = request()->get('current_password');
        $data['new_password'] = request()->get('new_password');
        $data['confirm_new_password'] = request()->get('confirm_new_password');

        $user = User::query()->where('id', Auth::user()->id)->first();

        if(Hash::check($data['current_password'], $user->password)){
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required',
                'confirm_new_password' => 'required'
            ]);
    
            DB::table('password_resets')->where([
                        'email' => $user->email, 
                        ])->first();
    
            User::where('email', $user->email)->update(['password' => Hash::make($data['new_password'])]);
    
            return ProfileController::GetObj()->profile($request);

        }else{
        }
        $infos = Exceptions::errorNotFoundHTML(_GL('Incorrect password'));
        return $this->settings($request, $infos);
    }


    protected function pageDetailSetBreadcrumbsLogout($params, $info = []){
        $params['_breadcrumbs'] = [];

        $prd = new SystemMenu();
        $prd->_name =  _GL('Logout');
        $prd->url = '';
        
        $params['_breadcrumbs'][] = $prd;
        
        return $params;
    }


    public function logout(Request $request, $infos = false)
    {   
        $params = array();
        if($infos) $params['_infosParams'] = $infos;
        $params['left_params']['usermenu'] = [];
        $params = $this->pageDetailSetBreadcrumbsLogout($params);

        return $this->GetView('BaseSite.Profile.logout', $params);
    }

    public function execLogout()
    {
        Auth::logout();
        $infos = Exceptions::errorNotFoundHTML(_GL('User Log out'));

        return UserCredentialsController::GetObj()->signIn($infos); 
    }
}