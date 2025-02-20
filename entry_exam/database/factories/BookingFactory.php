<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Hotel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{

    protected $model = Booking::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_id' => $this->faker->unique()->randomNumber(5), // ID
            'hotel_id' => Hotel::inRandomOrder()->first()->id ?? 1, // get ID hotel random or create hotel
            'customer_name' => $this->faker->name(),
            'customer_contact' => $this->faker->phoneNumber(),
            'checkin_time' => Carbon::now()->addDays(rand(1, 10)), // random 1-10 next day
            'checkout_time' => Carbon::now()->addDays(rand(11, 20)), // random 1-10 next day
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
