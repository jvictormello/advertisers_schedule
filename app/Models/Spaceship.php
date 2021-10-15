<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spaceship extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'capacity'
    ];
    
    protected $table = 'spaceships';
}
