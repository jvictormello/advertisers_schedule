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

    const STATUS_PENDING = 'Pendente';
    const STATUS_IN_PROGRESS = 'Em Andamento';
    const STATUS_FINISHED = 'Finalizado';
    const MAX_SCHEDULE_DURATION_IN_HOURS = 3;
    const ZERO_OVERTIME_HOURS = 0;

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

    /**
     * Get the advertiser that owns the schedule.
     */
    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class);
    }

    /**
     * Get the contractor that owns the schedule.
     */
    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    /**
     * Get the notifications for the schedule.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
