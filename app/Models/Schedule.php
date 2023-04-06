<?php

namespace App\Models;

use App\Enums\SchedulesStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => SchedulesStatus::class
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'advertiser_id',
        'contractor_id',
        'price',
        'contractor_zip_code',
        'status',
        'date',
        'starts_at',
        'finishes_at',
        'duration',
        'started_at',
        'finished_at',
        'amount',
    ];
}
