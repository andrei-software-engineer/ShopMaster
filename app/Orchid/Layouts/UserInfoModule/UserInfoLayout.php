<?php

namespace App\Orchid\Layouts\UserInfoModule;

use App\Models\Base\Status;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use App\Models\InfoUser\InfoUser;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;

class UserInfoLayout extends Table
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
                ->render(function (InfoUser $obj) {
                    return Link::make($obj->id)
                        ->route('platform.infouser.edit',$obj->_getModifyAdminParams());
                }),

            TD::make('nume','Name')
                ->sort()
                ->filter(Input::make())
                ->render(function (InfoUser $obj) {
                    return Link::make($obj->nume)
                        ->route('platform.infouser.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),

            TD::make('prenume','Surname')
                ->sort()
                ->filter(Input::make())
                ->render(function (InfoUser $obj) {
                    return $obj->prenume; }),

            TD::make('phone','Phone')
                ->sort()
                ->filter(Input::make())
                ->render(function (InfoUser $obj) {
                    return $obj->phone; }),

            TD::make('mobil','Mobile')
                ->sort()
                ->filter(Input::make())
                ->render(function (InfoUser $obj) {
                    return $obj->mobil; }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (InfoUser $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Link::make(__('Edit'))
                        ->route('platform.infouser.edit',$obj->_getModifyAdminParams())
                        ->icon('pencil'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.infouser.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
