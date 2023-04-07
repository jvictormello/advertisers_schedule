<?php

namespace Database\Factories;

use App\Models\Overtime;
use Illuminate\Database\Eloquent\Factories\Factory;

class OvertimeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Overtime::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'advertiser_id' => Overtime::first()->id,
            'amount' => 100.00,
        ];
    }
}
