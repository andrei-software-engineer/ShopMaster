<?php

namespace App\Orchid\Layouts\SystemVideoModule;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use App\Models\Base\SystemVideo;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

class SystemVideoLayout extends Table
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
                ->render(function (SystemVideo $obj) {
                    return $obj->id;
                }),
            
            TD::make('', 'Files')
                ->width('50')
                ->render(function (SystemVideo $obj) {
                    return "<a href='".$obj->location."' target=''><img src='".SystemVideo::getimageurl($obj)."' alt='".$obj->name."'  class='rounded-1 ' width='70'></a>";

            }),

            TD::make('name', 'Name')
                ->sort()
                ->filter(Input::make())
                ->render(function (SystemVideo $obj) {
                    return Link::make($obj->name)
                        ->href($obj->location)->target('');
                }),

            TD::make('host', 'Host')
                ->sort()
                ->filter(Input::make())
                ->render(function (SystemVideo $obj) {
                    return $obj->host;
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (SystemVideo $obj) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([
                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->action(route('platform.systemvideo.remove', ['id' => $obj->id]))
                            ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
