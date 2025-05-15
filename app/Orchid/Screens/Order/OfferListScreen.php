<?php

namespace App\Orchid\Screens\Order;

use App\Models\Product\Offer;
use App\Orchid\Layouts\OrderModule\OfferLayout;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Screens\BaseMediaScreen;
use Orchid\Screen\Actions\Link;

class OfferListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Offer::GetObj();
    }

        /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        $rez = parent::commandBar();
        
        if(request()->get('_backurl'))
        {
            $rez[] =                 
                Link::make(__('Back to main list'))
                    ->icon('plus')
                    ->href(request()->get('_backurl'));
        }
        

        $rez[] =                 
            Link::make(__('Add'))
                ->icon('plus')
                ->href(route('platform.offer.create', $this->targetClass->_getModifyAdminParams()));

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
            OfferLayout::class,
        ];
    }
}
