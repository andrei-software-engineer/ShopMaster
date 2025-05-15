<?php

namespace App\Orchid\Layouts\PaymentModule;

use Orchid\Screen\TD;
use App\Models\Base\Status;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\DropDown;
use App\Models\Payment\Paynettransactionjurnal;
use Orchid\Screen\Actions\Link;

class PaynetTransactionJurnalLayout extends Table
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
                ->render(function (Paynettransactionjurnal $obj) {
                    return $obj->id;
                }),
            
            TD::make('idpaynettransaction', 'Paynet Transaction ID')
                ->sort()
                ->filter(Input::make())
                ->render(function (Paynettransactionjurnal $obj) {
                    return $obj->idpaynettransaction;}),

            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('general_status', 'all')))
                    ->render(function (Paynettransactionjurnal $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),
                    

            TD::make('transactionjurnaltype', 'Paynet Transaction Type')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('paynet_transaction_type', 'all')))
                    ->render(function (Paynettransactionjurnal $obj) {
                        return $obj->paynet_transaction_text;
                            })->filterValue(function($item){return Status::GL($item);}),
                    

            TD::make('note',_GLA('Note'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Paynettransactionjurnal $obj) {
                    return $obj->note;}),

            TD::make('date', 'Date')
                ->sort()
                ->filter(Input::make())
                ->render(function (Paynettransactionjurnal $obj) {
                    return $obj->date_d;}),

        ];
    }
}
