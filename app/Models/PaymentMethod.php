<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_number',
        'user_id',
        'holder',
        'expiration_date',
        'security_code',
        'brand'
    ];
    
    protected $hidden = [
        'id', 
        'created_at', 
        'updated_at'
    ];
}
