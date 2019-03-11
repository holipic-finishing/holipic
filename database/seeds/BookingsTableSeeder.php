<?php

use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	Schema::disableForeignKeyConstraints();

        $faker = Faker\Factory::create();

        \App\Models\Booking::truncate();

        $customers = \App\Models\Customer::all();

        $photographers = \App\Models\Photographer::all();

        $randomCheckout = [1,0];

        for($i=0; $i<=20; $i++) {
        	\App\Models\Booking::create([
        		'customer_id' => $customers[$i]['id'],
                'photographer_id' => $photographers[$i]['id'],
                'country' => $faker->address,
                'checkout' => $faker->randomElement($randomCheckout),
                'date' => $faker->date(),
                'time' => $faker->time(),
        	]);
        }

    }
}
