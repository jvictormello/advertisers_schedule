<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'schedule_id',
        'message',
    ];

    /**
     * Get the schedule that owns the notification.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
