<?php

namespace App\Orchid\Screens\Faq;

use App\Models\Faq\Faq;
use Orchid\Screen\Actions\Link;
use App\Orchid\Layouts\FaqModule\FaqLayout;
use App\Orchid\Screens\BaseListScreen;

class FaqListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Faq::GetObj();
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
                ->href(route('platform.faq.create', $this->targetClass->_getModifyAdminParams()));

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
            FaqLayout::class,
        ];
    }
}
