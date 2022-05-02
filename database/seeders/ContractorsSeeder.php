<?php

namespace Database\Seeders;

use App\Models\Contractors;
use Illuminate\Database\Seeder;

class ContractorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contractors::factory(10)->create();
    }
}
