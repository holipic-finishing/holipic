<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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

        \App\Models\User::truncate();

        //create supper admin
        \App\Models\User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin', 
            'email' => 'admin@gmail.com', 
            'password' => bcrypt('123456'), 
            'role_id' => 1,
        ]);
        
        // create user
        for ($i=0; $i < 10 ; $i++) {
            \App\Models\User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'password' => bcrypt('123456'),
                'role_id' => 2,
                'package_id' => $faker->numberBetween(1, 2),
            ]);
        }

    }
}
