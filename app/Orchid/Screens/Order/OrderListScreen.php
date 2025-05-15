<?php

namespace App\Orchid\Screens\Order;

use App\Models\Order\Order;
use App\Orchid\Layouts\OrderModule\OrderLayout;
use App\Orchid\Screens\BaseListScreen;

class OrderListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Order::GetObj();
    }


    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            OrderLayout::class,
        ];
    }
}
