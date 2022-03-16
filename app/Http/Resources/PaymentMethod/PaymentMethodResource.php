<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'CardNumber' => $this->card_number,
            'Holder' => $this->holder,
            'ExpirationDate' => $this->expiration_date,
            'SecurityCode' => $this->security_code,
            'Brand' => $this->brand
        ];
    }
}
