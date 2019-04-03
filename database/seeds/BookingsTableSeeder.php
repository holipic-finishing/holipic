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

        // $companies = \App\Models\Company::with(['branchs'])->get();

        $companies = \App\Models\Company::with(['branchs' => function ($query) {
            return $query->with('customers')->with('photographers');
        }])->get();


        foreach ($companies as $company) {
            $branches = $company->branchs;
            $photographer_ids = [];
            $customer_ids = [];
            
            foreach ($branches as $branch) {
                $photographers = $branch->photographers;
                $customers = $branch->customers;


                foreach ($photographers as $photographer) {
                    $photographer_ids[] = $photographer->id;
                }

                foreach ($customers as $customer) {
                    $customer_ids[] = $customer->id;
                }
            }

            $randomCheckout = [1,0];

            for($i=0; $i<=2000; $i++) {
            	$booking = \App\Models\Booking::create([
            		'customer_id' => $faker->randomElement($customer_ids),
                    'photographer_id' => $faker->randomElement($photographer_ids),
                    'country' => $faker->address,
                    'checkout' => $faker->randomElement($randomCheckout),
                    'date' => $faker->dateTimeBetween('-30 days', '+30 days'),
                    'time' => $faker->time(),
            	]);


                /*Add detail booking table*/
                $roomId = \App\Models\Customer::select('room_id')->where('id', $booking['customer_id'])->first();

                $snapPhoto = \App\Models\SnapPhoto::whereRoomId($roomId)->first();

                $snapPhotoDetails = \App\Models\SnapPhotoDetail::whereSnapPhotoId($snapPhoto['id'])->get();

                if(!empty($snapPhotoDetails)) {
                    foreach($snapPhotoDetails as $value)
                    {
                        $bookingDetail = \App\Models\BookingDetail::create([
                                        'booking_id' => $booking['id'],
                                        'snap_photo_detail_id' => $value['id'],
                                        'quantity' => 1,
                                        'company_package_id' => null,
                                        'photo_package_id' => 4
                        ]);
                    }
                }

                /*Add detail booking table*/
            }
        };


    }
}
