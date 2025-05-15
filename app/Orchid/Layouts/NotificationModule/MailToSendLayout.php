<?php

namespace App\Orchid\Layouts\NotificationModule;

use Orchid\Screen\TD;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;

use App\Models\Base\Status;
use App\Models\Notification\MailToSend;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;

class MailToSendLayout extends Table
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
                ->render(function (MailToSend $obj) {
                    return Link::make($obj->id);
                }),

            TD::make('idsubscription', 'Group')
            ->sort()
            ->filter(Input::make())
            ->render(function (MailToSend $obj) {
                return $obj->subscription_group;
                    }),

            TD::make('idemailtemplate', 'Email')
                ->sort()
                ->filter(Input::make())
                ->render(function (MailToSend $obj) {
                    return $obj->subscription_email;
                        }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (MailToSend $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.mailtosend.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
