<?php

use Illuminate\Database\Seeder;

class ListingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        \App\Models\Listing::truncate();

        $faker = Faker\Factory::create();

        $bookings = \App\Models\Booking::with('customer')->with('photographer')->get()->toArray();

        for ($i=0; $i < 100; $i++) {

        	$booking = $faker->randomElement($bookings);
        	$customer_id = $booking['customer']['id'];
            $room_id = $booking['customer']['room_id'];
            $photographer_id = $booking['photographer']['id'];
            $branch_id = \App\Models\Photographer::where('id', $photographer_id)->first()->branch_id;

            \App\Models\Listing::create([
                'branch_id'         => $branch_id,
                'photographer_id'   => $photographer_id,
                'room_id'           => $room_id,
            ]);
            
            \App\Models\Order::where('customer_id', $customer_id)
                            ->where('photographer_id', $photographer_id)
                            ->where('branch_id', $branch_id)
                            ->update([
                                'status' => 'PENDING',
                                'created_at' => now(),
                            ]);

        	$key = array_search($booking, $bookings);
        	unset($bookings[$key]);
        }
    }
}
