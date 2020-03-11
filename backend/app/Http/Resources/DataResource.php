<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource as Resource;

class DataResource extends Resource
{
    /**
     * When you are converting a single model to json, that is a json resource, when you are converting a collection of model to json, that is resource collection.
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
        ];

        return $data;
    }
}
