<?php

namespace Database\Factories;

use App\Models\Advertiser;
use App\Models\Contractor;
use App\Models\Status;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'advertiser_id' = Advertiser::first()->id,
            'contractor_id' = Contractor::first()->id,
            'price' => $this->faker->randomFloat(2),
            'contractor_zip_code' => '80420-200',
            'status_id' => Status::first()->id,
            'date' => $this->faker->date(),
            'starts_at' => $this->faker->time(),
            'finishes_at' => $this->faker->time(),
            'duration' => $this->faker->numberBetween(1, 3),
            'started_at',
            'finished_at',
            'amount',
        ];
    }
}
