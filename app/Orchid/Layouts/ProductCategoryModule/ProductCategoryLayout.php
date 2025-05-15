<?php

namespace App\Orchid\Layouts\ProductCategoryModule;

use App\Models\Base\Status;
use App\Models\Category\Category;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use App\Models\ProductCategory\ProductCategory;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Select;

class ProductCategoryLayout extends Table
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
                ->render(function (ProductCategory $obj) {
                    return Link::make($obj->id)
                        ->route('platform.productcategory.edit',$obj->_getModifyAdminParams());
                }),

            TD::make('idcategory', 'Category')
                ->sort()
                ->render(function (ProductCategory $obj) {
                    return $obj->category_name;
                }),


            TD::make('idproduct', 'Product')
                ->sort()
                ->render(function (ProductCategory $obj) {
                    return $obj->product_name;
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (ProductCategory $obj) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([

                        Link::make(__('Edit'))
                            ->route('platform.productcategory.edit', $obj->_getModifyAdminParams())
                            ->icon('pencil'),

                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->action(route('platform.productcategory.remove', $obj->_getFiltersMedia()))
                            ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
