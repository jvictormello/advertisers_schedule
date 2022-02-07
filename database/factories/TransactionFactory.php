<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'payment_method_id' => PaymentMethod::factory()->create()->id,
            'name' => $this->faker->name(),
            'total_amount' => $this->faker->unique()->randomFloat(2),
        ];
    }
}
