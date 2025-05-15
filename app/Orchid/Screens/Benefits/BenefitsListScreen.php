<?php

namespace App\Orchid\Screens\Benefits;

use App\Models\Benefits\Benefits;
use App\Orchid\Screens\BaseListScreen;
use Orchid\Screen\Actions\Link;
use App\Orchid\Layouts\BenefitsModule\BenefitsLayout;

class BenefitsListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Benefits::GetObj();
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
                ->href(route('platform.benefits.create')),
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
            BenefitsLayout::class,
        ];
    }
}
