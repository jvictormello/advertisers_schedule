<?php

namespace Database\Factories;

use App\Models\Advertiser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AdvertiserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Advertiser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email,
            'username' => $this->faker->unique()->userName,
            'login' => $this->faker->unique()->userName,
            'password' => Hash::make('abcd1234'),
            'profile_description' => $this->faker->paragraph(),
        ];
    }
}
