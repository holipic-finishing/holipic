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

        $companies = \App\Models\Company::all();

        foreach ($companies as $company) {
            for ($i=0; $i < rand(5,10) ; $i++) {
                $password = $faker->password;

                $user =  \App\Models\User::create([
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'username' => $faker->userName,
                    'email' => $faker->email,
                    'password' => bcrypt($password),
                    'role_id' => 3,
                ]);

                \App\Models\Branch::create([
                    'name' => $faker->company,
                    'branch_password' => $password,
                    'branch_address' => $faker->address,
                    'branch_phone_number' => $faker->phoneNumber,
                    'company_id' => $company->id,
                    'user_id' => $user['id'],
                ]);                
            }
        }
    }
}
