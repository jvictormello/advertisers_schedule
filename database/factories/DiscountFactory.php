<?php

namespace Database\Factories;

use App\Models\Advertiser;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'advertiser_id' => Advertiser::find()->id,
            'hours' => null,
            'amount' => null,
        ];
    }

    /**
     * Define the amount for 1 hour.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function oneHour()
    {
        return $this->state(function (array $attributes) {
            return [
                'hours' => 1,
                'amount' => 0.00,
            ];
        });
    }

    /**
     * Define the amount for 2 hours.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function twoHours()
    {
        return $this->state(function (array $attributes) {
            return [
                'hours' => 2,
                'amount' => 20.00,
            ];
        });
    }

    /**
     * Define the amount for 3 hours.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function threeHours()
    {
        return $this->state(function (array $attributes) {
            return [
                'hours' => 3,
                'amount' => 40.00,
            ];
        });
    }
}
