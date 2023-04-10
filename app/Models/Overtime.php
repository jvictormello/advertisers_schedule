<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'advertiser_id',
        'amount',
    ];

    /**
     * Get the advertiser that owns the overtime.
     */
    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class);
    }
}
