<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaymentMethodCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection;
    }
}
