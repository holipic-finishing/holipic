<?php

use Illuminate\Database\Seeder;

class ShopSellerTableSeeder extends Seeder
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
        \App\Models\Seller::truncate();

        $branches = \App\Models\Branch::all();

        foreach ($branches as $branch) {
            for ($i=0; $i < rand(2, 5) ; $i++) {
                $user = \App\Models\User::create([
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'username' => $faker->userName.$faker->userName,
                    'email' => rand(1,100) . $faker->email,
                    'password' => bcrypt(123456),
                    'role_id' => 5,
                ]);

                \App\Models\Seller::create([
                    'user_id' => $user['id'],
                    'branch_id' => $branch->id,
                ]);
            }
        }
    }
}