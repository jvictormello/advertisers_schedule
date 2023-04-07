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
            ContractorSeeder::class,
            NotificationSeeder::class,
            AdvertiserSeeder::class,
            PriceSeeder::class,
            DiscountSeeder::class,
            OvertimeSeeder::class,
            ScheduleSeeder::class,
        ]);
    }
}
