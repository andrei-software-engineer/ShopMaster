<?php

namespace App\Orchid\Screens\Payment;

use Orchid\Screen\Actions\Link;
use App\Models\Payment\Paynetwallet;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Layouts\PaymentModule\PaynetWalletLayout;

class PaynetWalletListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Paynetwallet::GetObj();
    }

                /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        $rez = parent::commandBar();

        $rez[] =                 
            Link::make(__('Add'))
                ->icon('plus')
                ->href(route('platform.paynetwallet.create', $this->targetClass->_getModifyAdminParams()));

        return $rez;
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            PaynetWalletLayout::class,
        ];
    }
}
