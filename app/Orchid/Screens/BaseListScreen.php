<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\LabelModule\LabelLayout;
use App\Orchid\Layouts\User\UserFiltersLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;


class BaseListScreen extends Screen
{
    protected $specialView = '';
    /**
     * The base view that will be rendered.
     *
     * @return string
     */
    protected function screenBaseView(): string
    {
        if ($this->specialView)
            return $this->specialView;
            
        return 'platform::layouts.base';
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'objects' => $this->targetClass->_getAllAdmin()
        ];
    }

    /**
     * The name is displayed on the user's screen and in the headers
     */
    public function name(): ?string
    {
        $rez = $this->targetClass->_getAdminName(array('id'));
        if (request()->get('filter'))
        {
            $tf = request()->get('filter');

            if (is_array($tf) && isset($tf['parentmodel']))
            {
                if($tf['parentmodel'] == '-1') {
                    $rez .=  '';
                }else {
                    $rez .= ' - '.$tf['parentmodel'];
                }
            }

        }
        if (request()->get('_mediainfo'))
        {
            $rez .= ' '.request()->get('_mediainfo');
        }
        return $rez;
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return $this->targetClass->_getAdminDescription();
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.systems.roles',
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
            //
        ];
    }

}
