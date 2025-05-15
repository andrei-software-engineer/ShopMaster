<?php

namespace App\Orchid\Layouts\CategoryModule;

use Orchid\Screen\TD;
use App\Models\Base\Status;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use App\Models\Category\Category;

class CategoryLayout extends Table
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
                ->render(function (Category $obj) {
                    return Link::make($obj->id)
                        ->route('platform.category.edit',$obj->_getModifyAdminParams());}),
                    

            TD::make('order','Order')
                ->sort()
                ->filter(Input::make())
                ->render(function (Category $obj) {
                    return Link::make($obj->order)
                        ->route('platform.category.edit',$obj->_getModifyAdminParams());}),
                    
            TD::make('_name', 'Name')
                ->sort()
                ->filter(Input::make())
                ->render(function (Category $obj) {
                    return Link::make($obj->_name)
                        ->route('platform.category.edit',$obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),

            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('prd_fyl_ctg_status', 'all')))
                    ->render(function (Category $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),


            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (Category $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Link::make(__('Preview'))
                    ->href($obj->url)
                    ->target('_blank')
                    ->icon('eye'),
                    
                    Link::make(__('Edit'))
                    ->route('platform.category.edit',$obj->_getModifyAdminParams())
                    ->icon('pencil'),

                    Link::make(__('Gallery'))
                    ->route('platform.gallery.list', $obj->_getMediaAdminParams('platform.category.list'))
                    ->icon('picture'),

                    Link::make(__('Video'))
                    ->route('platform.cvideo.list', $obj->_getMediaAdminParams('platform.category.list'))
                    ->icon('camrecorder'),

                    Link::make(__('Attachements'))
                    ->route('platform.attachements.list', $obj->_getMediaAdminParams('platform.category.list'))
                    ->icon('link'),

                    Link::make(__('Special Filter'))
                    ->route('platform.specialfilterauto.list', $obj->_getMediaAdminParams('platform.category.list'))
                    ->icon('picture'),

                    Link::make(__('Filter Category'))
                    ->route('platform.filtercategory.list', $obj->_getFilterParams('platform.category.list'))
                    ->icon('picture'),

                    Link::make(__('Products'))
                    ->route('platform.productcategory.list', $obj->_getFilterParams('platform.category.list'))
                    ->icon('picture'),


                    Link::make(__('Faq'))
                    ->route('platform.faq.list', $obj->_getMediaAdminParams('platform.category.list'))
                    ->icon('quote'),

                    Link::make(__('Childrens'))
                    ->route('platform.category.list', $obj->_getChildAdminParams('platform.category.list'))
                    ->icon('picture'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.category.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
