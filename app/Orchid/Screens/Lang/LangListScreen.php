<?php

namespace App\Orchid\Screens\Lang;


use App\Models\Base\Lang;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Layouts\LangModule\LangLayout;

class LangListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Lang::GetObj();
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            LangLayout::class,
        ];
    }
}
