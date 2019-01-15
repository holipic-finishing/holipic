<?php

use Illuminate\Database\Seeder;

class CompanysTableSeeder extends Seeder
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

        \App\Models\Company::truncate();

        $users = \App\Models\User::where('role_id', 2)->get();
        
        // create company with user
        foreach ($users as $user) {
            \App\Models\Company::create([
                'name' => $faker->company,
                'description' => $faker->sentence(6, true),
                'address' => $faker->address,
                'logo' => $faker->image(public_path() . '/logos'),
                'owner_id' => $user->id,
                'phone' => $faker->phoneNumber,
            ]);
        }
    }
}
