<?php

use Illuminate\Database\Seeder;

class CouponCodeTableSeeder extends Seeder
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

        \App\Models\CouponCode::truncate();

        $discounts = [10, 20, 30, 40, 50];

        for ($i=0; $i < 10 ; $i++) {
        	$from_date = $faker->dateTimeBetween('-2 months', '-1 months');
        	$to_date = $faker->dateTimeBetween('now', '+2 months');

            \App\Models\CouponCode::create([
                'name' => ucwords(str_replace('.', '',$faker->sentence(2, true)) . ' coupon'),
		        'code' => $faker->ean13,
		        'discount' => $faker->randomElement($discounts),
		        'active' => rand(0,1),
		        'from_date' => $from_date,
		        'to_date' => $to_date
            ]);
        }
    }
}
