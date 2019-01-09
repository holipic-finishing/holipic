<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
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
        \App\Models\Customer::truncate();
        
        // create user with user
        for ($i=1; $i < 30 ; $i++) {
            \App\Models\Customer::create([
                'name' => $faker->name,
                'room_id' => $faker->randomNumber(1),
                'customer_password' => $faker->password,
                'avatar' => $faker->image,
                'branch_id' => 2,
                'address' => $faker->address,
                'status' => 1
            ]);
        }
    }
}
