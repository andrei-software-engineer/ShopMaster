<?php

namespace App\Orchid\Screens\Payment;

use App\Models\Payment\Paynettransactionjurnal;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Layouts\PaymentModule\PaynetTransactionJurnalLayout;

class PaynetTransactionJurnalListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Paynettransactionjurnal::GetObj();
    }


    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            PaynetTransactionJurnalLayout::class,
        ];
    }
}
