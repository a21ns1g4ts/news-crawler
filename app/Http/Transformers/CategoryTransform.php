<?php

namespace App\Http\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class CategoryTransform
 *
 * @package App\Http\Transformers
 */
class CategoryTransform extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = $this->collection->map(function ($obj){
           return [
               'text' => $obj->name,
               'value' =>  $obj->name
           ];
        });

        return [
            'data' => $data
        ];
    }
}
