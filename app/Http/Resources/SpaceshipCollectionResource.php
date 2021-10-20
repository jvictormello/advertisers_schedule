<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SpaceshipCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($spaceship){
                return [
                    'id'            => $spaceship->id,
                    'name'          => $spaceship->name,
                    'description'   => $spaceship->description,
                    'capacity'      => $spaceship->capacity,
                    'created_at'    => $spaceship->created_at,
                    'updated_at'    => $spaceship->updated_at
                ];
            })
        ];
    }
}
