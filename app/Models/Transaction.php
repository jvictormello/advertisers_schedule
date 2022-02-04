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
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];
}
