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
        
        // create photographer with branch
        for ($i=1; $i < 20 ; $i++) {
            // $company = \App\Models\Company::find($i);

            \App\Models\Photographer::create([
                'company_id' => 2,
                'branch_id' => 2,
                'name' => $faker->name,
                'phone_number' => $faker->phoneNumber,
                'address' => $faker->address,
                'status' => $faker->boolean,
            ]);
        }
    }
}
