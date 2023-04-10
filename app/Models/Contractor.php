<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'login',
        'password',
        'zip_code',
    ];

    /**
     * Get the schedules for the contractor.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
