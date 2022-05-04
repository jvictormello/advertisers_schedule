<?php

namespace Database\Factories;

use App\Models\Advertisers;
use App\Models\Availabilities;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvailabilitiesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Availabilities::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "advertiser_id" => Advertisers::inRandomOrder()->first()->id,
            "week_day" => $this->faker->numberBetween(0, 6),
            "start_time" => $this->faker->time(),
            "end_time" => $this->faker->time(),
        ];
    }
}
