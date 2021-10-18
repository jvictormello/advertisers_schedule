<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Spaceship;

class SpaceshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Spaceship::create([
            'name'        => 'Cheetoh',
            'description' => 'They are intelligent with the ability to learn quickly'
        ]);

        Spaceship::create([
            'name'        => 'Bengal',
            'description' => 'Extremely intelligent, curious and active'
        ]);
    }
}
