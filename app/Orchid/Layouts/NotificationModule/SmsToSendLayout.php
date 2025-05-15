<?php

namespace App\Orchid\Layouts\NotificationModule;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

use App\Models\Base\Status;
use App\Models\Notification\SmsToSend;

class SmsToSendLayout extends Table
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
                ->render(function (SmsToSend $obj) {
                    return Link::make($obj->id);
                }),

            TD::make('idsubscription', 'Group')
            ->sort()
            ->filter(Input::make())
            ->render(function (SmsToSend $obj) {
                return $obj->subscription_group;
                    }),

            TD::make('idsmstemplate', 'SMS')
                ->sort()
                ->filter(Input::make())
                ->render(function (SmsToSend $obj) {
                    return $obj->sms;
                        }),

            TD::make(__('Actions'))
            ->align(TD::ALIGN_CENTER) 
            ->width('100px')
            ->render(fn (SmsToSend $obj) => DropDown::make()
            ->icon('options-vertical')
            ->list([

                Button::make(__('Delete'))
                    ->icon('trash')
                    ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                    ->action(route('platform.smstosend.remove', $obj->_getFiltersMedia()))
                    ->canSee($obj->_canDelete()),
                ])),
                            
        ];
    }
}
