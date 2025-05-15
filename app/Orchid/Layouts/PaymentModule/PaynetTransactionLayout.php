<?php

namespace App\Orchid\Layouts\PaymentModule;

use Orchid\Screen\TD;
use App\Models\Base\Status;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use App\Models\Payment\Paynettransaction;


class PaynetTransactionLayout extends Table
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
                ->render(function (Paynettransaction $obj) {
                    return $obj->id;
                }),

            TD::make('idparentclass', 'Order ID')
                ->sort()
                ->filter(Input::make())
                ->render(function (Paynettransaction $obj) {
                    return $obj->idparentclass;}),


            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('general_status', 'all')))
                    ->render(function (Paynettransaction $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),
                    
                                         
            TD::make('site_amount', 'Site amount')
                ->sort()
                ->filter(Input::make())
                ->render(function (Paynettransaction $obj) {
                    return $obj->site_amount;}),


            TD::make('note',_GLA('Note'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Paynettransaction $obj) {
                    return $obj->note;}),


            TD::make('date', 'Date')
                ->sort()
                ->filter(Input::make())
                ->render(function (Paynettransaction $obj) {
                    return $obj->date_d;}),

        ];
    }
}
