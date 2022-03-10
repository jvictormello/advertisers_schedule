<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_amount',
        'payment_method_id',
        'user_id'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    } 

    public function user()
    {
        return $this->belongsTo(User::class);
    }  
}
