<?php

namespace App\Orchid\Layouts\NotificationModule;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

use App\Models\Base\Status;
use App\Models\Notification\SmsTemplate;

class SmsTemplateLayout extends Table
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
                ->render(function (SmsTemplate $obj) {
                    return Link::make($obj->id)
                        ->route('platform.smstemplate.edit',$obj->_getModifyAdminParams());
                }),

            TD::make('identifier', 'Identifier')
                ->sort()
                ->filter(Input::make())
                ->render(function (SmsTemplate $obj) {
                    return Link::make($obj->identifier)
                        ->route('platform.smstemplate.edit', $obj->_getModifyAdminParams());}),

            TD::make('fromname', 'From name')
                ->sort()
                ->filter(Input::make())
                ->render(function (SmsTemplate $obj) {
                    return $obj->fromname;
                        })->filterValue(function($item){return Status::GL($item);}),

            TD::make('tonumber', 'To number')
                ->sort()
                ->filter(Input::make())
                ->render(function (SmsTemplate $obj) {
                    return $obj->tonumber;
                        })->filterValue(function($item){return Status::GL($item);}),

            TD::make('_sms', 'Sms')
                ->sort()
                ->filter(Input::make())
                ->render(function (SmsTemplate $obj) {
                    return $obj->_sms;
                        })->filterValue(function($item){return Status::GL($item);}),

            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('general_status', 'all')))
                    ->render(function (SmsTemplate $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),
                    
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (SmsTemplate $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Link::make(__('Edit'))
                    ->route('platform.smstemplate.edit',$obj->_getModifyAdminParams())
                    ->icon('pencil'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.smstemplate.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
