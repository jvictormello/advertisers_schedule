<?php

namespace Database\Seeders;

use App\Models\Availabilities;
use Illuminate\Database\Seeder;

class AvailabilitiesSeeder extends Seeder
{
    private $failures = 0;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            Availabilities::factory(100)->create();
        } catch(\Exception $e) {

            if($this->failures > 10) {
                return;
            }
            
            $this->failures++;
            $this->run();
        }
    }
}
