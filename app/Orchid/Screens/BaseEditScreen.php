<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Fields\ViewField;
use Orchid\Screen\Screen;
use App\Models\Base\Lang;
use App\Models\Base\Status;
use App\Models\Page\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Alert;

class BaseEditScreen extends Screen
{

    public function changeLang(Request $request, $id)
    {
        $_idlang = $request->get('_idlang');
        if (!$_idlang) exit();

        return $this->targetClass->_adminChangeLang($id, $_idlang);
    }
    
    public function changePage(Request $request, $id)
    {
        $idpage = $request->get('idpage');
        if (!$idpage) exit();

        return $this->targetClass->_adminChangePage($id, $idpage);
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function _query($obj): array
    {
        // $obj->_fill(request()->get('obj'));

        $params = array();
        $params['_admin'] = '1';
        $params['_wr'] = '1';

        if (request()->get('_idlang') != null)
        {
            $params['_idlang'] = request()->get('_idlang');
        }

        $obj->_setParams();

        $obj->processObject($obj, $params);

        return [
            'obj' => $obj,
        ];
    }
    
    public function _createOrUpdate($obj, Request $request, $routePart = false)
    {
        $words = $this->targetClass->getWords();
        $obb = $request->get('obj');


        if(isset($request->get('obj')['_name']) && !isset($request->get('obj')['_title'])){
            $obb['_title'] = $request->get('obj')['_name'];
        }

        if(isset($request->get('obj')['_name']) && !isset($request->get('obj')['_slug'])){
            $obb['_slug'] = strtolower($request->get('obj')['_name']);
        }
        
        $obj->_fill($obb);
        
        $error = NULL;
        $message = NULL;
        $obj->_save($error, $message);

        
        if($error){
            Alert::error($message);

        }else{
            $params = $obj->_getFiltersMedia();
            $params = (array) $params;
            $t = json_decode(request()->get('obj')['_requestInfo'], true);
            $t['_idlang'] = $obj->_getIdLang();
            $params = array_merge($params, $t);            

            
            $routePart = ($routePart !== false) ? $routePart : strtolower($obj->_getClassName()); 
            Alert::info('You have successfully created a '.$obj->_getClassName().'.');
            
            return redirect()->route('platform.'.$routePart.'.edit', $params);
        }

    }

    public function _createOrUpdateNotification($obj, Request $request, $routePart = false)
    {
        $routePart = ($routePart !== false) ? $routePart : strtolower($obj->_getClassName()); 
        Alert::info('You have successfully created a '.$obj->_getClassName().'.');
        return redirect()->route('platform.'.$routePart.'.list', $obj->_getModifyRequestInfo($request));

    }

    public function remove($obj, Request $request, $routePart = false)
    {

        $routePart = ($routePart !== false) ? $routePart : strtolower($obj->_getClassName()); 
        $obj->_delete();

        Alert::info('You have successfully deleted the '.$obj->_getClassName().'.');

        return redirect()->route('platform.'.$routePart.'.list', $obj->_getModifyRequestInfo($request));
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar($routePart = false): array
    {
        $routePart = ($routePart !== false) ? $routePart : strtolower($this->obj->_getClassName()); 

        return [
            Button::make('Create')
                ->icon('pencil')
                ->id("UpdateButton")
                ->method('createOrUpdate')
                ->canSee(!$this->obj->exists),

            Button::make('Back to list')
                ->icon('note')
                ->method('backroute')
                ->canSee($this->obj->exists),

            Button::make('Update')
                ->icon('note')
                ->id("UpdateButton")
                ->method('createOrUpdate')
                ->canSee($this->obj->exists),

            Button::make('Remove')
                ->icon('trash')
                ->confirm('Description of the consequences of removal...')
                ->action(route('platform.'.$routePart.'.remove', $this->obj->_getFiltersMedia()))
                ->canSee($this->obj->canDelete),

            Button::make('Cancel')
                ->icon('note')
                ->method('backroute'),
        ];
    }

    /**
     * The name is displayed on the user's screen and in the headers
     */
    public function name(): ?string
    {
        return $this->obj->exists ? 'Edit '.$this->obj->_getClassName() : 'Creating a new '.$this->obj->_getClassName();
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return $this->obj->_getClassName()." modify page";
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
        ];
    }

    protected function getSelectLang()
    {
        $languages = Lang::_getDropDownAdminLanguages();


        $url = route('platform.'.$this->obj->_getClassName(true).'.editcl', $this->obj);
        $url .= '?_idlang=';

        return 
                Select::make('obj._idlang')
                    ->options($languages)
                    ->title(_GLA('TI_lang'))
                    ->placeholder(_GLA('PH_select lang'))
                    ->class('js_CA_select')
                    ->set('data-updateurl',$url)
                    ;
    }

    protected function getSelectPage()
    {
        $pages = Page::_getAllForSelect(array('pagetype' => Status::PAGE_GENERAL), array('_words' => 1));

        $url = route('platform.'.$this->obj->_getClassName(true).'.editcl', $this->obj);
        $url .= '?idpage=';

        return 
                Select::make('obj.idpage')
                ->class('js_linktype_'.Status::MENU_TYPE_LINKTOPAGE)
                ->options($pages)
                ->class('js_CA_select')
                ->title(_GLA('TI_page'))
                ->placeholder(_GLA('PH_select page'))
                ->set('data-updateurl',$url);

    }

    protected function getCKEditor($name)
    {
        $params = [];
        $params['value'] = $this->obj->$name;
        $params['obj'] = $this->obj;
        $params['name'] = $name;
        $params['filedname'] = 'obj['.$name.']';
        $params['mainid'] = $this->obj->_getAdminId($name);

        return
            ViewField::make('obj.'. $name)
                    ->view('Orchid.ckeditorGeneral')
                    ->set('params', $params)
                    ;
    }
    

    public function delete(String $id,  Request $request, $routePart = false)
    {
        $obj = $this->targetClass->where('id', $id)->first();
        return $this->remove($obj, $request, $routePart);
    }

    public function _backroute($obj, Request $request, $routePart = false)
    {
        if(request()->get('obj')){
            $baclURL = json_decode(request()->get('obj')['_requestInfo'], true);

            if(array_key_exists("backUrl",$baclURL)){
                $url = $baclURL['backUrl'];
                return redirect()->to($url);
            }
        }
       
        $routePart = ($routePart !== false) ? $routePart : strtolower($obj->_getClassName()); 
        
        return redirect()->route('platform.'.$routePart.'.list', $obj->_getModifyRequestInfo($request));

    }
}