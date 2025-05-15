<?php

namespace App\Orchid\Layouts\FavoriteModule;

use Orchid\Screen\TD;
use App\Models\Favorite\Favorite;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;


class FavoriteLayout extends Table
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
                ->render(function (Favorite $obj) {
                        return $obj->id;
                    }),

            TD::make('iduser', 'User')
                ->sort()
                ->filter(Input::make())
                ->render(function (Favorite $obj) {
                    return $obj->adminName;
                }),

            TD::make('idproduct', 'Product')
                ->sort()
                ->filter(Input::make())
                ->render(function (Favorite $obj) {
                    if ($obj->productObj) {
                        return $obj->product_name;
                    } else {
                        return 'nu exista';
                    }
                }),


            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Favorite $obj) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([

                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->action(route('platform.favorite.remove', $obj->_getFiltersMedia()))
                            ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
