<?php

namespace App\GeneralClasses;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Orchid\Screen\Fields\Relation;
use Orchid\Support\Assert;

class FromMyRelation extends Relation
{
    
    
    /**
     * @var string
     */
    protected $view = 'Orchid.relation';

    /**
     * @param string|Model $model
     * @param string       $name
     * @param string|null  $key
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return Relation
     */
    public function fromModel(string $model, string $name, string $key = null): self
    {
        $key = $key ?? resolve($model)->getModel()->getKeyName();

        $this
            ->set('relationModel', Crypt::encryptString($model))
            ->set('relationName', Crypt::encryptString($name))
            ->set('relationKey', Crypt::encryptString($key));

        return $this->addBeforeRender(function () use ($model, $name, $key) {
            $append = $this->get('relationAppend');



            if (is_string($append)) {
                $append = Crypt::decryptString($append);
            }

            $text = $append ?? $name;
            $value = $this->get('value');

            if (! is_iterable($value)) {
                $value = Arr::wrap($value);
            }

            if (! Assert::isObjectArray($value)) {
                $value = $model::whereIn($key, $value)->get();
            }


            $value = collect($value)
                ->map(static fn ($item) => [
                    'id'   => $item->$key,
                    'text' => $item->$text,
                ])->toArray();
            $this->set('value', $value);
        });
    }

}