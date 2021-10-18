<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpaceshipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'description'   => $this->description,
            'capacity'      => $this->capacity,
            'info_from_api' => $this->info_from_api,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at
        ];
    }
}
