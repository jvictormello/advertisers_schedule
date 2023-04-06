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
        $fakeDate = $this->faker->dateTimeBetween('+0 days', '3 days');
        $date = $fakeDate->format('Y-m-d');
        $startsAt = $fakeDate->format('H:i:s');
        $duration = $this->faker->numberBetween(1, 3);
        $finishesAt = $fakeDate->modify('+ '.$duration.' hours')->format('H:i:s');

        return [
            'advertiser_id' = Advertiser::first()->id,
            'contractor_id' = Contractor::first()->id,
            'price' => $this->faker->randomFloat(2),
            'contractor_zip_code' => '80420-200',
            'status_id' => Status::first()->id,
            'date' => $date,
            'starts_at' => $startsAt,
            'finishes_at' => $finishesAt,
            'duration' => $duration,
        ];
    }
}
