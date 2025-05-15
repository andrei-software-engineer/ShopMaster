<?php

namespace App\Orchid\Layouts\PageModule;

use App\Models\Base\Lang;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;

use App\Models\Base\Status;
use App\Models\Page\Page;

class PageLayout extends Table
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
                ->render(function (Page $obj) {
                    return Link::make($obj->id)
                        ->route('platform.page.edit',$obj->_getModifyAdminParams());
                }),
            
            TD::make('_name', 'Name')
                ->sort()
                ->filter(Input::make())
                ->render(function (Page $obj) {
                    return Link::make($obj->_name)
                        ->route('platform.page.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),

            TD::make('pagetype', 'Page Type')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('page_type', 'all')))
                    ->render(function (Page $obj) {
                        return Link::make($obj->pagetype_text)
                        ->route('platform.page.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),

            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('general_status', 'all')))
                    ->render(function (Page $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),
                    
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (Page $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Link::make(__('Preview'))
                    ->href($obj->url)
                    ->target('_blank')
                    ->icon('eye'),
                    
                    Link::make(__('Edit'))
                    ->route('platform.page.edit', $obj->_getModifyAdminParams())
                    ->icon('pencil'),

                    Link::make(__('Gallery'))
                    ->route('platform.gallery.list', $obj->_getMediaAdminParams('platform.page.list'))
                    ->icon('picture'),

                    Link::make(__('Video'))
                    ->route('platform.cvideo.list', $obj->_getMediaAdminParams('platform.page.list'))
                    ->icon('camrecorder'),

                    Link::make(__('Attachements'))
                    ->route('platform.attachements.list', $obj->_getMediaAdminParams('platform.page.list'))
                    ->icon('link'),

                    Link::make(__('Faq'))
                    ->route('platform.faq.list', $obj->_getMediaAdminParams('platform.page.list'))
                    ->icon('quote'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.page.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
