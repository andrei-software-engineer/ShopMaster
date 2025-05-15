<?php

namespace App\Orchid\Screens\Attachements;

use App\Orchid\Screens\BaseEditScreen;
use App\Models\Base\Status;
use App\Models\Base\SystemFile;
use App\Models\Base\Attachements;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\ViewField;
use Orchid\Support\Facades\Layout;

class AttachementsEditScreen extends BaseEditScreen
{
    /**
     * @var Attachements
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Attachements::GetObj();
    }

    /**
     * Query data.
     *
     * @param Attachements $obj
     *
     * @return array
     */
    public function query(Attachements $obj): array
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
        $data = Status::GA('media_type');
        $data2 = Status::GA('yesno');
        $str_arr =  explode(".", Route::currentRouteName());

        $x = [];

        $x[] =  Input::make('obj._requestInfo')->set('hidden', true);
        $x[] =  Input::make('obj.parentmodel')->set('hidden', true);
        $x[] =  Input::make('obj.parentmodelid')->set('hidden', true);
        $x[] =  $this->getSelectLang();
        $x[] =  Input::make('obj.ordercriteria')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_ordercriteria'))->id($this->obj->_getAdminId('ordercriteria'))->placeholder(_GLA('PH_set ordercriteria'));
        $x[] =  Select::make('obj.status')->options($data)->class('js_CA_select')->title(_GLA('TI_status'))->id($this->obj->_getAdminId('status'))->placeholder(_GLA('PH_select status'));
        $x[] =  Select::make('obj.isdefault')->options($data2)->class('js_CA_select')->title(_GLA('TI_isdefault'))->id($this->obj->_getAdminId('isdefault'))->placeholder(_GLA('PH_select isdefault'));
        $x[] =  Input::make('obj._name')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_name'))->id($this->obj->_getAdminId('_name'))->placeholder(_GLA('PH_select name'));
        
        if($str_arr[2] == "create"){
            $x[] =  Input::make('raw_file')->type('file')->title('File input ')->horizontal();
        }else {
            $x[] = ViewField::make('view')->view('Orchid.attachements')->set('obj', $this->obj);
        }

        return [
            Layout::rows($x)
        ];
    }

    /**
     * @param Attachements    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Attachements $obj, Request $request)
    {
        if (!$obj->id) $obj->idsystemfile = SystemFile::saveFiles($request->file('raw_file'));
        $t = $request->file('raw_file');

        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(Attachements $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

