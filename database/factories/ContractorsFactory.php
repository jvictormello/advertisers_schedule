<?php

namespace Database\Factories;

use App\Models\Contractors;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractorsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contractors::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
        ];
    }
}
