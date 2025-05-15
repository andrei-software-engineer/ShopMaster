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
use App\Models\Order\Order;

class OrderLayout extends Table
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
                ->render(function (Order $obj) {
                    return Link::make($obj->id)
                        ->route('platform.order.edit',$obj->_getModifyAdminParams());
                }),

            TD::make('destinatar_name', 'Destinatar Name')
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(function (Order $obj) {
                    return Link::make($obj->destinatar_name)
                        ->route('platform.order.edit', $obj->_getModifyAdminParams());
                }),

            TD::make('destinatar_email', 'Destinatar Email')
                ->sort()
                ->filter(Input::make())
                ->render(function (Order $obj) {
                    return $obj->destinatar_email;
                }),

            TD::make('destinatar_company', 'Destinatar Company')
                ->sort()
                ->filter(Input::make())
                ->render(function (Order $obj) {
                    return $obj->destinatar_company;
                }),

            TD::make('status', 'Status')
                ->render(function (Order $obj) {
                    return $obj->status_text;
                })->filterValue(function ($item) {
                    return Status::GL($item);
                }),


            TD::make('data', 'Data')
                ->sort()
                ->filter(Input::make())
                ->render(function (Order $obj) {
                    return $obj->order_data;}),
                

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Order $obj) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([

                        Link::make(__('Edit'))
                            ->route('platform.order.edit',  $obj->_getModifyAdminParams())
                            ->icon('pencil'),

                        Link::make(__('Order Details'))
                            ->route('platform.orderdetails.list',  $obj->_getModifyAdminParams('platform.order.edit'))
                            ->icon('pencil'),


                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->action(route('platform.order.remove', ['id' => $obj->id]))
                            ->canSee($obj->_canDelete()),


            ])),
        ];
    }
}
