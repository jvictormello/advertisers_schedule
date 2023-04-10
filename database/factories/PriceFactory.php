<?php

namespace Database\Factories;

use App\Models\Advertiser;
use App\Models\Price;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Price::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'advertiser_id' => Advertiser::first()->id,
            'amount' => 150.00,
        ];
    }
}
