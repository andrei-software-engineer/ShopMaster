<?php

namespace App\Orchid\Layouts\ConfigModule;

use App\Models\Base\Config;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

class ConfigLayout extends Table
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
                ->render(function (Config $obj) {
                    return Link::make($obj->id)
                        ->route('platform.config.edit',$obj->_getModifyAdminParams());}),

            TD::make('identifier','Identifier')
            ->sort()
            ->filter(Input::make())
            ->render(function (Config $obj) {
                return Link::make($obj->identifier)
                    ->route('platform.config.edit',  $obj->_getModifyAdminParams());}),
            
            TD::make('value','Value')
                ->sort()
                ->filter(Input::make())
                ->render(function (Config $obj) {
                    return Link::make($obj->value)
                        ->route('platform.config.edit',  $obj->_getModifyAdminParams());}),
            
            TD::make('comments','Comments')
                ->sort()
                ->filter(Input::make())
                ->render(function (Config $obj) {
                    return $obj->comments; }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (Config $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([
                    Link::make(__('Edit'))
                    ->route('platform.config.edit',  $obj->_getModifyAdminParams())
                    ->icon('pencil'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.config.remove', ['id' => $obj->id]))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
