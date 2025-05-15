<?php

namespace App\Orchid\Screens\SystemMenu;

use App\Models\Base\Status;
use App\Models\Base\SystemMenu;
use App\Models\Page\Page;
use App\Models\Base\Acl;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use App\Orchid\Screens\BaseEditScreen;

class SystemMenuEditScreen extends BaseEditScreen
{
    /**
     * @var SystemMenu
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = SystemMenu::GetObj();
    }

    /**
     * Query data.
     *
     * @param SystemMenu $obj
     *
     * @return array
     */
    public function query(SystemMenu $obj): array
    {
        $obj = parent::_query($obj);

        if ($obj['obj'] && !$obj['obj']->id)
        {
            $obj['obj']->idparent = request()->query()['idparent'];
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
        $menu_status = Status::GA('menu_status');
        $menu_section = Status::GA('menu_section');
        $menu_type = Status::GA('menu_type');
        $routes = Acl::getRouteFromGroup('web', '{');

        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                $this->getSelectLang(),

                Input::make('obj.ordercriteria')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_ordercriteria'))
                    ->id($this->obj->_getAdminId('ordercriteria'))
                    ->placeholder(_GLA('PH_set ordercriteria')),

                Input::make('obj.idparent')
                    ->set('hidden', true),
                    
                Input::make('obj._name')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_name'))
                    ->id($this->obj->_getAdminId('_name'))
                    ->placeholder(_GLA('PH_set name')),

                Select::make('obj.status')
                    ->options($menu_status)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_status'))
                    ->id($this->obj->_getAdminId('status'))
                    ->placeholder(_GLA('PH_select status')),

                Select::make('obj.section')
                    ->options($menu_section)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_section'))
                    ->id($this->obj->_getAdminId('section'))
                    ->placeholder(_GLA('PH_select section')),

                Select::make('obj.linktype')
                    ->options($menu_type)
                    ->title(_GLA('TI_linktype'))
                    ->id($this->obj->_getAdminId('linktype'))
                    ->class('js_CA_select')
                    ->set('data-oneach', '1')
                    ->set('data-hideinfo', '1')
                    ->set('data-showinfo', '1')
                    ->placeholder(_GLA('PH_select linktype')),

                Input::make('customlink')
                    ->class('js_CA_enter form-control js_linktype_'.Status::MENU_TYPE_CUSTOM)
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_customlink'))
                    ->id($this->obj->_getAdminId('customlink'))
                    ->placeholder(_GLA('PH_select customlink')),
                    
                $this->getSelectPage(),
                    
                Select::make('customlink_special')
                    ->class('js_linktype_'.Status::MENU_TYPE_SPECIALLINK)
                    ->options($routes)
                    ->title(_GLA('TI_customlink'))
                    ->id($this->obj->_getAdminId('customlink'))
                    ->placeholder(_GLA('PH_select customlink')),
            ])
        ];
    }


    /**
     * @param SystemMenu $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(SystemMenu $obj, Request $request)
    {
        // --------------------
        $t = $request->request->all();


        if ($t['obj']['linktype'] == Status::MENU_TYPE_CUSTOM)
        {
            $obj->customlink = $t['customlink'];
            $obj->idpage = 0;
        } elseif ($t['obj']['linktype'] == Status::MENU_TYPE_SPECIALLINK)
        {
            $obj->customlink = $t['customlink_special'];
            $obj->idpage = 0;
        } elseif ($t['obj']['linktype'] == Status::MENU_TYPE_LINKTOPAGE)
        {
            $obj->customlink = $obj->url;
        } elseif ($t['obj']['linktype'] == Status::MENU_TYPE_NOLINK)
        {
            $obj->customlink = '';
            $obj->idpage = 0;
        }

        
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(SystemMenu $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

