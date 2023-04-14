<?php

namespace Database\Factories;

use App\Models\Advertiser;
use App\Models\Contractor;
use App\Models\Discount;
use App\Models\Price;
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
        $advertiserId = Advertiser::first()->id;
        $fakeDate = $this->faker->dateTimeBetween('+0 days', '3 days');
        $date = $fakeDate->format('Y-m-d');
        $startsAt = $fakeDate->format('Y-m-d H:i:s');
        $duration = $this->faker->numberBetween(1, 3);
        $finishesAt = $fakeDate->modify('+ '.$duration.' hours')->format('Y-m-d H:i:s');
        $price = Price::where('advertiser_id', $advertiserId)->first()->amount - (Discount::where('advertiser_id', $advertiserId)->where('hours', $duration)->first()->amount);

        return [
            'advertiser_id' => $advertiserId,
            'contractor_id' => Contractor::first()->id,
            'price' => $price,
            'contractor_zip_code' => '80420-200',
            'date' => $date,
            'starts_at' => $startsAt,
            'finishes_at' => $finishesAt,
            'duration' => $duration,
            'started_at' => null,
            'finished_at' => null,
            'amount' => null,
        ];
    }
}
