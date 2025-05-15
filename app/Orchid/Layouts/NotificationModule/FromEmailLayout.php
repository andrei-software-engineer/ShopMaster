<?php

namespace App\Orchid\Layouts\NotificationModule;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

use App\Models\Base\Status;
use App\Models\Notification\FromEmail;

class FromEmailLayout extends Table
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
                ->render(function (FromEmail $obj) {
                    return Link::make($obj->id)
                        ->route('platform.fromemail.edit',$obj->_getModifyAdminParams());
                }),

            TD::make('email', 'Email')
                ->sort()
                ->filter(Input::make())
                ->render(function (FromEmail $obj) {
                    return Link::make($obj->email)
                        ->route('platform.fromemail.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),

            TD::make('password', 'password')
                ->sort()
                ->filter(Input::make())
                ->render(function (FromEmail $obj) {
                    return $obj->password;
                        })->filterValue(function($item){return Status::GL($item);}),

            TD::make('smtphost', 'smtphost')
                ->sort()
                ->filter(Input::make())
                ->render(function (FromEmail $obj) {
                    return $obj->smtphost;
                        })->filterValue(function($item){return Status::GL($item);}),

            TD::make('smtpport', 'smtpport')
                ->sort()
                ->filter(Input::make())
                ->render(function (FromEmail $obj) {
                    return $obj->smtpport;
                        })->filterValue(function($item){return Status::GL($item);}),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (FromEmail $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Link::make(__('Edit'))
                    ->route('platform.fromemail.edit',$obj->_getModifyAdminParams())
                    ->icon('pencil'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.fromemail.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
