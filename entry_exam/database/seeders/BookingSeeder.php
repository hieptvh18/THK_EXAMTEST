<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TRUNCATE DATABASE
        Schema::disableForeignKeyConstraints(); // invalid foreign key constraints
        DB::table('bookings')->truncate();
        Schema::enableForeignKeyConstraints(); // valid foreign key constraints

        // auto create bookings
        Booking::factory(20)->create();
    }
}
