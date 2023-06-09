<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'schedule_id' => Schedule::first()->id,
            'message' => $this->faker->paragraph(),
        ];
    }
}
