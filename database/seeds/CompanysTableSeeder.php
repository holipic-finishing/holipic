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
        
        // create company with user
        for ($i=1; $i < 52 ; $i++) {
            $user = \App\Models\User::find($i);
            \App\Models\Company::create([
                'name' => $user['company_name'],
                'description' => $faker->sentence(6, true),
                'address' => $faker->address,
                'owner_id' => $user['id'],
                'logo' => $faker->image(public_path() . '/logos'),
                'phone' => $faker->phoneNumber,
            ]);
        }
    }
}
