<?php

namespace Database\Seeders;

use App\Models\Overtime;
use Illuminate\Database\Seeder;

class OvertimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Overtime::factory()->create();
    }
}
