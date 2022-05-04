<?php

namespace Database\Seeders;

use App\Models\Advertisers;
use Illuminate\Database\Seeder;

class AdvertisersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Advertisers::factory(30)->create();
    }
}
