<?php

namespace App\Orchid\Layouts\OrderModule;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;

use App\Models\Base\Status;
use App\Models\Product\Offer;
use App\Models\Product\Product;

class OfferLayout extends Table
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
                ->render(function (Offer $obj) {
                    return Link::make($obj->id)
                        ->route('platform.offer.edit',$obj->_getModifyAdminParams());
                }),

            
            TD::make('idproduct', _GLA('Product'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(function (Offer $obj) {
                    return Link::make($obj->productObj->_name)
                        ->route('platform.offer.edit', $obj->_getModifyAdminParams());}),
                        
            TD::make('priority',_GLA('priority'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Offer $obj) {
                    return $obj->priority;}),
            
            TD::make('status', _GLA('Status'))
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('lang', 'all')))
                    ->render(function (Offer $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),
            
            TD::make('maxq',_GLA('maxq'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Offer $obj) {
                    return $obj->maxq;}),

            TD::make('pricewoutvat',_GLA('pricewoutvat'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Offer $obj) {
                    return $obj->pricewoutvat;}),


            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (Offer $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([
                    Link::make(__('Edit'))
                    ->route('platform.offer.edit', $obj->_getModifyAdminParams())
                    ->icon('pencil'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.offer.remove', ['id' => $obj->id]))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];

    }
}
