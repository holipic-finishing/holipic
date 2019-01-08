<?php

use Illuminate\Database\Seeder;

class BranchesTableSeeder extends Seeder
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

        \App\Models\Branch::truncate();
        
        // create branch with company
        for ($i=1; $i < 20 ; $i++) {
            $company = \App\Models\Company::find($i);
            $user = \App\Models\User::find($i);

            \App\Models\Branch::create([
                'company_id' => $company['id'],
                'name' => $faker->name,
                'user_id' => $user['id'],
                'branch_password' => $faker->password,
                'branch_address' => $faker->address,
                'branch_phone_number' => $faker->phoneNumber,
            ]);
        }
    }
}
