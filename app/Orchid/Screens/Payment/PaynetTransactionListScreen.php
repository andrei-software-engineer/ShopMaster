<?php

namespace App\Orchid\Screens\Payment;

use App\Models\Payment\Paynettransaction;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Layouts\PaymentModule\PaynetTransactionLayout;

class PaynetTransactionListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Paynettransaction::GetObj();
    }


    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            PaynetTransactionLayout::class,
        ];
    }
}
