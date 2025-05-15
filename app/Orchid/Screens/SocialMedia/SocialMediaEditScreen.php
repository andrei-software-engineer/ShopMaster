<?php

namespace App\Orchid\Screens\SocialMedia;

use App\Models\Base\Status;
use App\Models\SocialMedia\SocialMedia;
use App\Models\Base\SystemFile;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use App\Orchid\Screens\BaseEditScreen;
use Orchid\Screen\Fields\ViewField;
use Illuminate\Support\Facades\Route;

class SocialMediaEditScreen extends BaseEditScreen
{
    /**
     * @var SocialMedia
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = SocialMedia::GetObj();
    }

    /**
     * Query data.
     *
     * @param SocialMedia $obj
     *
     * @return array
     */
    public function query(SocialMedia $obj): array
    {
        return parent::_query($obj);
    }

    /**
     * Views.
     *
     * @return Layout[]
     */

     public function layout(): array
     {
        $pag_status = Status::GA('page_status');
        $str_arr =  explode(".", Route::currentRouteName());

        $x = [];

        $x[] =  Input::make('obj._requestInfo')->set('hidden', true);
        $x[] =  $this->getSelectLang();
        $x[] =  Select::make('obj.status')->options($pag_status)->class('js_CA_select')->title(_GLA('TI_status'))->id($this->obj->_getAdminId('status'))->placeholder(_GLA('PH_select status'));
        $x[] =  Input::make('obj._name')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_name'))->id($this->obj->_getAdminId('_name'))->placeholder(_GLA('PH_set name'));
        $x[] =  Input::make('obj.socialUrl')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_socialUrl'))->id($this->obj->_getAdminId('_socialUrl'))->placeholder(_GLA('PH_set socialUrl'));
        $x[] =  Input::make('obj.specialClass')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_specialClass'))->id($this->obj->_getAdminId('_specialClass'))->placeholder(_GLA('PH_set specialClass'));
        $x[] =  Input::make('obj.ordercriteria')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_ordercriteria'))->id($this->obj->_getAdminId('ordercriteria'))->placeholder(_GLA('PH_set ordercriteria'));
        $x[] =  Input::make('raw_file')->type('file')->title('File input ')->horizontal();

        if ($this->obj->systemfileobj) $x[] = ViewField::make('view')->view('Orchid.gallery')->set('obj', $this->obj);

        return [
            Layout::rows($x)
        ];
     }


    /**
     * @param SocialMedia    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(SocialMedia $obj, Request $request)
    {
        $obj->idSystemFile = SystemFile::saveFiles($request->file('raw_file'), $obj->idSystemFile);
        return parent::_createOrUpdate($obj, $request);
    }

    public function delete(String $id,  Request $request, $routePart = false)
    {
        return parent::delete($id, $request);
    }

    public function backroute(SocialMedia $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

