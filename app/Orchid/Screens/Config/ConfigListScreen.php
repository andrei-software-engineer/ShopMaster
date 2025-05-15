<?php

namespace App\Orchid\Screens\Config;

use App\Models\Base\Config;
use App\Orchid\Layouts\ConfigModule\ConfigLayout;
use App\Orchid\Screens\BaseListScreen;

class ConfigListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Config::GetObj();
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            ConfigLayout::class
        ];
        exit();
    }
}
