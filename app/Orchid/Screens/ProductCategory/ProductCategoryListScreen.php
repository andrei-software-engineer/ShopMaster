<?php

namespace App\Orchid\Screens\ProductCategory;

use Orchid\Screen\Actions\Link;
use App\Orchid\Screens\BaseListScreen;
use App\Models\ProductCategory\ProductCategory;
use App\Orchid\Layouts\ProductCategoryModule\ProductCategoryLayout;


class ProductCategoryListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = ProductCategory::GetObj();
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
        
        if(isset(request()['filter']))    {
            if(isset(request()['filter']['idproduct'])){
                $rez[] =  Link::make(__('Add'))
                ->icon('plus')
                ->href(route('platform.productcategory.create', $this->targetClass->_getModifyAdminParams()));
            }
        } 

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
            ProductCategoryLayout::class,
        ];
    }
}
