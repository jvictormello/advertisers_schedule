<?php

namespace App\Http\Resources\Sale;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SaleCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection;
    }
}
