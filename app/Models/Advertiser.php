<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertiser extends Model
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
        'username',
        'login',
        'password',
        'profile_description',
    ];

    /**
     * Get the schedules for the advertiser.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Get the prices for the advertiser.
     */
    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    /**
     * Get the discounts for the advertiser.
     */
    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    /**
     * Get the overtimes for the advertiser.
     */
    public function overtimes()
    {
        return $this->hasMany(Overtime::class);
    }
}
