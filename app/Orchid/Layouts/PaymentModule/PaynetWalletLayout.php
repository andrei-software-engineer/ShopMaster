<?php

namespace App\Orchid\Layouts\PaymentModule;

use Orchid\Screen\TD;
use App\Models\Base\Status;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use App\Models\Payment\Paynetwallet;


class PaynetWalletLayout extends Table
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
                ->render(function (Paynetwallet $obj) {
                    return $obj->id;
                }),

            TD::make('ordercriteria',_GLA('ordercriteria'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Paynetwallet $obj) {
                    return Link::make($obj->ordercriteria)
                        ->route('platform.paynetwallet.edit', $obj->_getModifyAdminParams());}),
                
            TD::make('merchant_code',_GLA('Merchant code'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Paynetwallet $obj) {
                    return $obj->merchant_code;}),

            TD::make('merchant_secretkey',_GLA('Merchant secretkey'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Paynetwallet $obj) {
                    return $obj->merchant_secretkey;}),

            TD::make('merchant_user',_GLA('Merchant user'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Paynetwallet $obj) {
                    return $obj->merchant_user;}),

            TD::make('merchant_userpass',_GLA('Merchant userpass'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Paynetwallet $obj) {
                    return $obj->merchant_userpass;}),

            TD::make('notification_secretkey',_GLA('Notification secretkey'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Paynetwallet $obj) {
                    return $obj->notification_secretkey;}),


            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('general_status', 'all')))
                    ->render(function (Paynetwallet $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),
                    

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (Paynetwallet $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Link::make(__('Edit'))
                    ->route('platform.paynetwallet.edit', $obj->_getModifyAdminParams())
                    ->icon('pencil'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.paynetwallet.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
