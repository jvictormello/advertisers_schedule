<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdvertisersSeeder::class
        ]);
        $this->call([
            ContractorsSeeder::class
        ]);
        $this->call([
            UserSeeder::class
        ]);
        $this->call([
            AvailabilitiesSeeder::class
        ]);
    }
}
