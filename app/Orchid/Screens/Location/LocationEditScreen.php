<?php

namespace App\Orchid\Screens\Location;

use App\Models\Base\Status;
use App\Models\Base\SystemFile;
use App\Models\Location\Location;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use App\Orchid\Screens\BaseEditScreen;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Fields\ViewField;

class LocationEditScreen extends BaseEditScreen
{
    /**
     * @var Location
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Location::GetObj();
    }

    /**
     * Query data.
     *
     * @param Location $obj
     *
     * @return array
     */
    public function query(Location $obj): array
    {
        $obj = parent::_query($obj);

        if ($obj['obj'] && !$obj['obj']->id)
        {
            $obj['obj']->idparent = request()->query()['idparent'];

            if($obj['obj']->idparent == 0){
                $obj['obj']->level = 1;
            }else{
                $t = Location::_get($obj['obj']->idparent);
                $obj['obj']->level = $t->level + 1;
            }
        }
        
        return $obj;
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    { 
        $location_status = Status::GA('general_status');
        $isdefault = Status::GA('isdefault');
        $str_arr =  explode(".", Route::currentRouteName());

        $x = [];

        $x[] =  Input::make('obj._requestInfo')->set('hidden', true);
        $x[] =  Input::make('obj.idparent')->set('hidden', true);
        $x[] =  Input::make('obj.level')->set('hidden', true);
        $x[] =  $this->getSelectLang();
        $x[] =  Input::make('obj.order')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_order'))->id($this->obj->_getAdminId('order'))->placeholder(_GLA('PH_set order'));
        $x[] =  Input::make('obj._name')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI__name'))->id($this->obj->_getAdminId('_name'))->placeholder(_GLA('PH_set _name'));
        $x[] =  Input::make('obj._urlsuffix')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI__urlsuffix'))->id($this->obj->_getAdminId('_urlsuffix'))->placeholder(_GLA('PH_set _urlsuffix'));
        $x[] =  Input::make('obj.shortname')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_shortname'))->id($this->obj->_getAdminId('shortname'))->placeholder(_GLA('PH_set shortname'));
        $x[] =  Input::make('obj.price')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_price'))->id($this->obj->_getAdminId('price'))->placeholder(_GLA('PH_set price'));
        $x[] =  Select::make('obj.status')->options($location_status)->class('js_CA_select')->title(_GLA('TI_status'))->id($this->obj->_getAdminId('status'))->placeholder(_GLA('PH_select status'));
        $x[] =  Select::make('obj.isdefault')->options($isdefault)->class('js_CA_select')->title(_GLA('TI_isdefault'))->id($this->obj->_getAdminId('isdefault'))->placeholder(_GLA('PH_select isdefault'));

        if($str_arr[2] == "create"){
            $x[] =  Input::make('raw_file')->type('file')->title('File input ')->horizontal();
        }else {
            $x[] = ViewField::make('view')->view('Orchid.gallery')->set('obj', $this->obj);
        }

        return [
            Layout::rows($x)
        ];

    }


    /**
     * @param Location $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Location $obj, Request $request)
    {
        if (!$obj->id) $obj->idlogo = SystemFile::saveFiles($request->file('raw_file'));

        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(Location $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

