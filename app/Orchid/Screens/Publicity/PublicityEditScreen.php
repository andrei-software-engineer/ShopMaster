<?php

namespace App\Orchid\Screens\Publicity;

use App\Models\Base\DT;
use App\Models\Publicity\Publicity;
use App\Models\Base\Status;
use App\Models\Base\SystemFile;
use App\Models\Base\SystemVideo;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use App\Orchid\Screens\BaseEditScreen;
use Orchid\Screen\Fields\ViewField;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Fields\DateTimer;


class PublicityEditScreen extends BaseEditScreen
{
    /**
     * @var Publicity
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Publicity::GetObj();
    }

    /**
     * Query data.
     *
     * @param Publicity $obj
     *
     * @return array
     */
    public function query(Publicity $obj): array
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
        $adv_section = Status::GA('adv_section');
        $adv_type = Status::GA('adv_type');
        $str_arr =  explode(".", Route::currentRouteName());

        $x = [];

        $x[] =  Input::make('obj._requestInfo')->set('hidden', true);
        $x[] =  Input::make('obj.parentmodel')->set('hidden', true);
        $x[] =  Input::make('obj.parentmodelid')->set('hidden', true);
        $x[] =  $this->getSelectLang();
        $x[] =  Select::make('obj.status')->options($pag_status)->class('js_CA_select')->title(_GLA('TI_status'))->id($this->obj->_getAdminId('status'))->placeholder(_GLA('PH_select status'));
        $x[] =  Input::make('obj._name')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_name'))->id($this->obj->_getAdminId('_name'))->placeholder(_GLA('PH_set name'));
        $x[] =  Select::make('obj.advsection')->options($adv_section)->class('js_CA_select')->title(_GLA('TI_advsection'))->id($this->obj->_getAdminId('Advsection'))->placeholder(_GLA('PH_select Advsection'));
        $x[] =  Select::make('obj.advtype')->options($adv_type)->class('js_CA_select')->title(_GLA('TI_advtype'))->id($this->obj->_getAdminId('advtype'))->placeholder(_GLA('PH_select advtype'));
        $x[] =  Input::make('obj.targettype')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_targettype'))->id($this->obj->_getAdminId('targettype'))->placeholder(_GLA('PH_set targettype'));
        $x[] =  Input::make('obj.urltogo')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_urltogo'))->id($this->obj->_getAdminId('urltogo'))->placeholder(_GLA('PH_set urltogo'));
        $x[] =  Input::make('obj.clickeds')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_clickeds'))->id($this->obj->_getAdminId('clickeds'))->placeholder(_GLA('PH_set clickeds'));
        
        $x[] =  DateTimer::make('startdate_d')->allowEmpty()->value($this->obj->startdate_d)->title('Start date')->format('d.m.Y'); 
        $x[] =  DateTimer::make('enddate_d')->allowEmpty()->value($this->obj->enddate_d)->title('End date')->format('d.m.Y'); 
        $x[] =  $this->getCKEditor('_description');

        $x[] =  Input::make('raw_file')->type('file')->title('Image ')->horizontal();
        $x[] =  Input::make('raw_file_mobile')->type('file')->title('Image Mobile ')->horizontal();
        $x[] =  Input::make('raw_video')->type('text')->title('Video input ')->horizontal();
 

        if ($this->obj->systemfileobj || $this->obj->systemfileobjMobile) $x[] = ViewField::make('view')->view('Orchid.gallery')->set('obj', $this->obj);
        if ($this->obj->systemvideoobj) $x[] = ViewField::make('view')->view('Orchid.video')->set('obj', $this->obj);

        return [
            Layout::rows($x)
        ];
     }


    /**
     * @param Publicity    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Publicity $obj, Request $request)
    {
        $obj->idimage = SystemFile::saveFiles($request->file('raw_file'), $obj->idimage);
        $obj->idimagemobile = SystemFile::saveFiles($request->file('raw_file_mobile'), $obj->idimagemobile);
        
        $x = request()->request;

        $url= $x->get('raw_video');
        $t = SystemVideo::SV_URL($url, $obj->idvideo);
        if ($t)  $obj->idvideo = $t->id;
        $obj->startdate = ($x->get('startdate_d')) ? DT::toTimeStamp($x->get('startdate_d').' 00:00:00') : null;
        $obj->enddate = ($x->get('enddate_d')) ? DT::toTimeStamp($x->get('enddate_d').' 23:59:59') : null;
        
        return parent::_createOrUpdate($obj, $request);
    }

    public function delete(String $id,  Request $request, $routePart = false)
    {
        return parent::delete($id, $request);
    }

    public function backroute(Publicity $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

