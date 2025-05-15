<?php

namespace App\Orchid\Layouts\ProductModule;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;

use App\Models\Base\Status;
use App\Models\Product\Product;

class ProductLayout extends Table
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
                ->render(function (Product $obj) {
                    return Link::make($obj->id)
                        ->route('platform.product.edit',$obj->_getModifyAdminParams());
                }),


            TD::make('order','Order')
                ->sort()
                ->filter(Input::make())
                ->render(function (Product $obj) {
                    return Link::make($obj->order)
                        ->route('platform.product.edit', $obj->_getModifyAdminParams());}),
                    
            TD::make('_name', 'Name')
                ->sort()
                ->filter(Input::make())
                ->render(function (Product $obj) {
                    return Link::make($obj->_name)
                        ->route('platform.product.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),


            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('prd_fyl_ctg_status', 'all')))
                    ->render(function (Product $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),


            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (Product $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Link::make(__('Preview'))
                    ->href($obj->url)
                    ->target('_blank')
                    ->icon('eye'),
                    
                    Link::make(__('Edit'))
                    ->route('platform.product.edit',$obj->_getModifyAdminParams())
                    ->icon('pencil'),

                    Link::make(__('Filter Product'))
                    ->route('platform.filterproduct.list', $obj->_getFilterProduct('platform.product.list'))
                    ->icon('picture'),

                    Link::make(__('Categories'))
                    ->route('platform.productcategory.list', $obj->_getFilterProduct('platform.product.list'))
                    ->icon('picture'),

                    Link::make(__('Gallery'))
                    ->route('platform.gallery.list', $obj->_getMediaAdminParams('platform.product.list'))
                    ->icon('picture'),

                    Link::make(__('Video'))
                    ->route('platform.cvideo.list', $obj->_getMediaAdminParams('platform.product.list'))
                    ->icon('camrecorder'),

                    Link::make(__('Attachements'))
                    ->route('platform.attachements.list', $obj->_getMediaAdminParams('platform.product.list'))
                    ->icon('link'),

                    Link::make(__('Faq'))
                    ->route('platform.faq.list', $obj->_getMediaAdminParams('platform.product.list'))
                    ->icon('quote'),

                    Link::make(__('Offer'))
                    ->route('platform.offer.list', $obj->_getOfferParams('platform.product.list'))
                    ->icon('quote'),


                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.product.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
