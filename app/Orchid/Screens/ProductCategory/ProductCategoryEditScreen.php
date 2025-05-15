<?php

namespace App\Orchid\Screens\ProductCategory;

use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Category\Category;
use Orchid\Screen\Fields\Relation;
use Orchid\Support\Facades\Layout;
use App\Orchid\Screens\BaseEditScreen;
use App\Models\ProductCategory\ProductCategory;
use Orchid\Screen\Fields\Input;

class ProductCategoryEditScreen extends BaseEditScreen
{
    /**
     * @var ProductCategory
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = ProductCategory::GetObj();
    }

    /**
     * Query data.
     *
     * @param ProductCategory $obj
     *
     * @return array
     */
    public function query(ProductCategory $obj): array
    {
        return parent::_query($obj);
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    { 
        return [
            Layout::rows([
                Input::make('obj._requestInfo')
                    ->set('hidden', true),
                $this->obj->locationselect('idcategory', 1, '', 0),
            ])
        ];
    }


    /**
     * @param ProductCategory    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(ProductCategory $obj, Request $request)
    {
        $obj->idproduct = json_decode($request['obj']['_requestInfo'])->filter->idproduct;
        $idcategory = array_filter($request['idcategory']); // Remove any falsey values
        $idcategory = array_reverse($idcategory); // Reverse the order of the remaining values
        $idcategory = reset($idcategory);

        $obj->idcategory = $idcategory;    
            
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(ProductCategory $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

