<?php

namespace App\Orchid\Screens\Maps;

use App\Orchid\Screens\BaseEditScreen;
use App\Models\Base\Status;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use App\Models\Maps\Maps;
use Orchid\Screen\Fields\Map;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\ViewField;
use Orchid\Support\Facades\Layout;

class MapsEditScreen extends BaseEditScreen
{
    /**
     * @var Maps
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Maps::GetObj();
    }

    /**
     * Query data.
     *
     * @param Maps $obj
     *
     * @return array
     */
    public function query(Maps $obj): array
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
        $status = Status::GA('general_status');
        $type = Status::GA('map_type');
        $coordinates = Maps::_get($this->obj->id, array('_full' => '1'));
        
        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                $this->getSelectLang(),

                Select::make('obj.status')
                    ->options($status)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_status'))
                    ->id($this->obj->_getAdminId('status'))
                    ->placeholder(_GLA('PH_select status')),
                    
                Select::make('obj.typecontactpoint')
                    ->options($type)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_typecontactpoint'))
                    ->id($this->obj->_getAdminId('typecontactpoint'))
                    ->placeholder(_GLA('PH_select typecontactpoint')),

                Input::make('obj._name')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_name'))
                    ->id($this->obj->_getAdminId('_name'))
                    ->placeholder(_GLA('PH_set _name')),

                Input::make('obj._title')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_title'))
                    ->id($this->obj->_getAdminId('_title'))
                    ->placeholder(_GLA('PH_set _title')),

                ViewField::make('view')
                    ->view('Orchid.googleMapsAdmin')->set('coordinates', $coordinates),

                $this->getCKEditor('_description')

            ])
        ];
    }

    /**
     * @param Maps    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Maps $obj, Request $request)
    {
        $obj->lat = $request->get('lat');
        $obj->lng = $request->get('lng');
        
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(Maps $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

