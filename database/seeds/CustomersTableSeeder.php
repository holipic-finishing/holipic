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
        
        $branches = \App\Models\Branch::all();

        foreach ($branches as $branch) {
            \App\Models\Customer::create([
                'name' => $faker->name,
                'room' => $faker->randomNumber(5),
                'email' => $faker->email,
                'password' => $faker->password,
                'avatar' => $faker->image,
                'branch_id' => 2,
                'address' => $faker->address,
                'status' => 1
            ]);
        }
    }
}
