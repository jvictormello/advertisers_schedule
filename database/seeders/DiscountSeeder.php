<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Discount::factory()->create(['hours' => 1, 'amount' => 0.00]);
        Discount::factory()->create(['hours' => 2, 'amount' => 20.00]);
        Discount::factory()->create(['hours' => 3, 'amount' => 40.00]);
    }
}
