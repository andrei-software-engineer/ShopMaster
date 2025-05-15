<?php

namespace App\Orchid\Layouts\PaymentModule;

use Orchid\Screen\TD;
use App\Models\Base\Status;
use App\Models\Payment\Transaction;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Fields\Input;

class TransactionLayout extends Table
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
                ->render(function (Transaction $obj) {
                    return $obj->id;
                }),

            
            TD::make('value', 'Value')
                ->sort()
                ->render(function (Transaction $obj) {
                    return $obj->value;
                }),


            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('general_status', 'all')))
                    ->render(function (Transaction $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),


            TD::make('type', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('payment_status', 'all')))
                    ->render(function (Transaction $obj) {
                        return $obj->type;
                            })->filterValue(function($item){return Status::GL($item);}),

            TD::make('date', 'Date')
                ->sort()
                ->filter(Input::make())
                ->render(function (Transaction $obj) {
                    return $obj->date_d;}),
            

        ];
    }
}
