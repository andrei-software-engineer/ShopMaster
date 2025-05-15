<?php

namespace App\Orchid\Layouts\NotificationModule;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

use App\Models\Base\Status;
use App\Models\Notification\Subscription;
use Orchid\Screen\Fields\Input;

class SubscriptionLayout extends Table
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
                ->render(function (Subscription $obj) {
                    return Link::make($obj->id)
                        ->route('platform.subscription.edit',$obj->_getModifyAdminParams());
                }),


            TD::make('name', 'Name')
                ->sort()
                ->filter(Input::make())
                ->render(function (Subscription $obj) {
                    return Link::make($obj->name)
                    ->route('platform.subscription.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),

            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('general_status', 'all')))
                    ->render(function (Subscription $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),
                            

            TD::make('email', 'Email')
                ->sort()
                ->filter(Input::make())
                ->render(function (Subscription $obj) {
                    return $obj->email;
                        })->filterValue(function($item){return Status::GL($item);}),

            TD::make('group', 'Groups')
                ->sort()
                ->filter(Input::make())
                ->render(function (Subscription $obj) {
                    return $obj->group;
                        })->filterValue(function($item){return Status::GL($item);}),

            TD::make('phone', 'Phone')
                ->sort()
                ->filter(Input::make())
                ->render(function (Subscription $obj) {
                    return $obj->phone;
                        })->filterValue(function($item){return Status::GL($item);}),

            TD::make('criteria', 'Criteria')
                ->sort()
                ->filter(Input::make())
                ->render(function (Subscription $obj) {
                    return $obj->criteria;
                        })->filterValue(function($item){return Status::GL($item);}),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (Subscription $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Link::make(__('Edit'))
                    ->route('platform.subscription.edit', $obj->_getModifyAdminParams())
                    ->icon('pencil'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.subscription.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
