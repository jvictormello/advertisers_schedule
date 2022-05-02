<?php

namespace Database\Factories;

use App\Models\Advertisers;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertisersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Advertisers::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "age" => $this->faker->numberBetween(18, 45),
        ];
    }
}
