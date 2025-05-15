<?php

namespace App\Orchid\Layouts\SystemFileModule;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use App\Models\Base\SystemFile;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

class SystemFileLayout extends Table
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
                ->render(function (SystemFile $obj) {
                    return $obj->id;
                }),

            TD::make('', 'Files')
                ->width('50')
                ->render(function (SystemFile $obj) {
                    if($obj->isImage()){
                        return "<a href='".SystemFile::cdnUrl($obj->id)."' target=''><img src='".SystemFile::cdnUrl($obj->id, 50, 50)."' alt='".$obj->name."'  class='rounded-1'></a>";
                    }
            }),

            TD::make('name', 'Name')
                ->sort()
                ->filter(Input::make())
                ->render(function (SystemFile $obj) {
                    return Link::make($obj->name)
                        ->href(SystemFile::cdnUrl($obj->id))->target('');
                }),

            TD::make('filetype', 'File Type')
                ->sort()
                ->filter(Input::make())
                ->render(function (SystemFile $obj) {
                    return $obj->filetype;
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (SystemFile $obj) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([
                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->action(route('platform.systemfile.remove', ['id' => $obj->id]))
                            ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
