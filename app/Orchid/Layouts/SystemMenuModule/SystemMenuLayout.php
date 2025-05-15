<?php

namespace App\Orchid\Layouts\SystemMenuModule;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;

use App\Models\Base\Status;
use App\Models\Base\SystemMenu;

class SystemMenuLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'objects';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
                                                                                               
            TD::make('id','ID')
                ->sort()
                ->filter(Input::make())
                ->render(function (SystemMenu $obj) {
                    return Link::make($obj->id)
                        ->route('platform.systemmenu.edit',$obj->_getModifyAdminParams());
                }),
            
            TD::make('ordercriteria', 'Order Criteria')
            ->sort()
            ->filter(Input::make())
            ->render(function (SystemMenu $obj) {
                return Link::make($obj->ordercriteria)
                        ->route('platform.systemmenu.edit', $obj->_getModifyAdminParams());}),

            TD::make('_name', 'Name')
                ->sort()
                ->filter(Input::make())
                ->render(function (SystemMenu $obj) {
                    return Link::make($obj->_name)
                        ->route('platform.systemmenu.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),

            TD::make('idparent','')
                ->filter(Input::make())
                ->defaultHidden(true),

            TD::make('section', 'Section')
                ->sort()
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('menu_section', 'all')))
                    ->render(function (SystemMenu $obj) {
                        return $obj->section_text;
                            })->filterValue(function($item){return Status::GL($item);}),

            TD::make('status', 'Status')
                ->sort()
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('general_status', 'all')))
                    ->render(function (SystemMenu $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),

            TD::make('linktype', 'Link Type')
                ->sort()
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('menu_section', 'all')))
                    ->render(function (SystemMenu $obj) {
                        return $obj->linktype_text;
                            })->filterValue(function($item){return Status::GL($item);}),

            TD::make('', 'Page Text')
                ->sort()
                ->render(function (SystemMenu $obj) {
                    return $obj->page_text;
                            }),
                    
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (SystemMenu $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list(
                    $this->getDetails($obj)
                )),
        ];
    }

    protected function getDetails($obj)
    {
        $details = array();

        if ($obj && $obj->url)
        {
            $details[] = Link::make(__('Preview'))
                    ->href($obj->url)
                    ->target('_blank')
                    ->icon('eye');
        } 

        $details[] = Link::make(__('Edit'))
                    ->route('platform.systemmenu.edit', $obj->_getModifyAdminParams())
                    ->icon('pencil');

        $details[] = Link::make(__('Childrens'))
                    ->route('platform.systemmenu.list', $obj->_getChildAdminParams('platform.systemmenu.list'))
                    ->icon('picture');

        $details[] = Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.systemmenu.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete());
        return $details;
    }
}
