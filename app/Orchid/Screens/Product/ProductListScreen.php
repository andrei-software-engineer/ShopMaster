<?php

namespace App\Orchid\Screens\Product;

use Orchid\Screen\Actions\Link;
use App\Models\Product\Product;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Layouts\ProductModule\ProductLayout;

class ProductListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Product::GetObj();
    }



            /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->href(route('platform.product.create')),
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            ProductLayout::class,
        ];
    }
}
