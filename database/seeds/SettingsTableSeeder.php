<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
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

        \App\Models\Setting::truncate();

        $packages = \App\Models\Package::all();

        foreach ($packages as $package) {
        	\App\Models\Setting::create([
        		'expiration_date' => rand(10, 20),
		        'card_fee' => $faker->randomFloat(2, 2, 5),
		        'bonus' => $faker->randomFloat(2, 2, 5),
		        'sms' => rand(0, 1),
		        'email_service' => rand(0, 1),
		        'package_id' => $package->id
        	]);
        }
    }
}
