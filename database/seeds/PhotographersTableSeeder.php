<?php

use Illuminate\Database\Seeder;

class PhotographersTableSeeder extends Seeder
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

        \App\Models\Photographer::truncate();

        $branches = \App\Models\Branch::all();

        foreach ($branches as $branch) {
            for ($i=0; $i < rand(3,8); $i++) { 
                \App\Models\Photographer::create([    
                    'name' => $faker->name,
                    'phone_number' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'status' => $faker->boolean,
                    'branch_id' => $branch->id,
                    'avatar' => $faker->image(public_path() . '/photographers/avatars'),
                    'email' => $faker->email,
                    'identification_card' => ''
                ]);
            }
        }
    }
}
