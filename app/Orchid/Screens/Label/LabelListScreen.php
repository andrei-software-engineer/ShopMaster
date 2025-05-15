<?php

namespace App\Orchid\Screens\Label;

use App\Models\Base\Label;
use App\Orchid\Layouts\LabelModule\LabelLayout;
use App\Orchid\Screens\BaseListScreen;

class LabelListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Label::GetObj();
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            LabelLayout::class
            
        ];
        exit();
    }
}
