<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'advertiser_id',
        'hours',
        'amount',
    ];

    /**
     * Get the advertiser that owns the discount.
     */
    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class);
    }
}
