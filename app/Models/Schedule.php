<?php

namespace App\Models;

use App\Enums\SchedulesStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;

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
