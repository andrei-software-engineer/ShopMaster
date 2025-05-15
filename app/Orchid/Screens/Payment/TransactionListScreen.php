<?php

namespace App\Orchid\Screens\Payment;

use App\Models\Payment\Transaction;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Layouts\PaymentModule\TransactionLayout;

class TransactionListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Transaction::GetObj();
    }


    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            TransactionLayout::class,
        ];
    }
}
