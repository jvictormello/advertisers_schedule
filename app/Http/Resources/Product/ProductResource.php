<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'Title' => $this->title,
            'Price' => $this->price,
            'Quantity' => $this->quantity,
            'ImageUrl' => $this->image_url
        ];
    }
}
