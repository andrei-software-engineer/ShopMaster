<?php

namespace App\Http\Controllers\General;

use App\Models\Base\Status;
use App\Models\Product\Product;
use Orchid\Platform\Http\Controllers\RelationController;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Facades\Crypt;
use Orchid\Platform\Http\Requests\RelationRequest;

class MyRelationController extends RelationController
{

    /**
     * @param RelationRequest $request
     *
     * @return JsonResponse
     */
    public function view(RelationRequest $request)
    {


        [
            'model'         => $model,
            'name'          => $name,
            'key'           => $key,
            'scope'         => $scope,
            'append'        => $append,
            'searchColumns' => $searchColumns,
        ] = collect($request->all())
            ->except(['search', 'chunk'])
            ->map(static function ($item, $key) {
                if ($item === null) {
                    return null;
                }

                if ($key === 'scope' || $key === 'searchColumns') {
                    return Crypt::decrypt($item);
                }

                return Crypt::decryptString($item);
            });

        /** @var Model $model */
        /** @psalm-suppress UndefinedClass */
        $model = new $model;
        $search = $request->get('search', '');

        $items = $this->buildersItems($model, $name, $key, $search, $scope, $append, $searchColumns, (int) $request->get('chunk', 100));

        return response()->json($items);
    }

    /**
     * @param Model       $model
     * @param string      $name
     * @param string      $key
     * @param string|null $search
     * @param array|null  $scope
     * @param string|null $append
     * @param array|null  $searchColumns
     * @param int|null    $chunk
     *
     * @return mixed
     */
    private function buildersItems(
        Model $model,
        string $name,
        string $key,
        string $search = null,
        ?array $scope = [],
        ?string $append = null,
        ?array $searchColumns = null,
        ?int $chunk = 10
    ) {
        if ($scope !== null) {
            /** @var Collection|array $model */
            $model = $model->{$scope['name']}(...$scope['parameters']);
        }

        if (is_array($model)) {
            $model = collect($model);
        }

        if (is_a($model, BaseCollection::class)) {
            return $model->take($chunk)->pluck($append ?? $name, $key);
        }


        $search = '%'. $search.'%';

        $f = array();
        $f['_where']['status'] = Status::ACTIVE;
        $f['_where']['tpw.value'] = ['_act' => 'LIKE', $search];
        $f['_leftJoin'][] = ['_tb' => 'product_word', '_alias' => 'tpw', '_fromc' => 'id', '_toc' => 'idparent'];
        $f['_start'] = 0;
        $f['_limit'] = 10;
        
        $value = $model::_getAllForSelect($f,  array('_full' => '1', '_musttranslate' => 1));

        return $value;
    }
}
