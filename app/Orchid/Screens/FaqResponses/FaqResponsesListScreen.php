<?php

namespace App\Orchid\Screens\FaqResponses;

use App\Models\Faq\FaqResponses;
use Orchid\Screen\Actions\Link;
use App\Orchid\Layouts\FaqModule\FaqResponsesLayout;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Screens\BaseMediaScreen;

class FaqResponsesListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = FaqResponses::GetObj();
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
                ->href(route('platform.faqresponses.create',$this->targetClass->_getModifyAdminParams()));

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
            FaqResponsesLayout::class,
        ];
    }
}
