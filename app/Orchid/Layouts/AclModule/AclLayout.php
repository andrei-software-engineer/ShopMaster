<?php

namespace App\Orchid\Layouts\AclModule;

use App\Models\Base\Acl;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Fields\CheckBox;

class AclLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'objects';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('role_id','Role_ID')
                ->sort()
                ->filter(Input::make())
                ->render(function (Acl $obj) {
                    return $obj->role_id;}),
            
            TD::make('route','Route')
                ->sort()
                ->filter(Input::make())
                ->render(function (Acl $obj) {
                    return $obj->route;}),
            
            TD::make('value','Value')
                ->sort()
                ->filter(Input::make())
                ->render(function (Acl $obj) {
                    return $obj->value;}),
            
            TD::make('module','Module')
                ->sort()
                ->filter(Input::make())
                ->render(function (Acl $obj) {
                    return $obj->module;}),
            
            TD::make('Rolurile')
                ->render(function (Acl $obj){
                    return CheckBox::make()
                        ->value($obj->id)
                        ->checked(false);}),
        ];

    }

}
