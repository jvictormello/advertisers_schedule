<?php

namespace App\Http\Resources\Sale;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'CardNumber' => $this->paymentMethod->getLastDigits(),
            'UserId' => $this->user_id,
            'Name' => $this->user->name,
            'Amount' => $this->total_amount,
            'Date' => $this->created_at->format('d/m/Y')
        ];
    }
}