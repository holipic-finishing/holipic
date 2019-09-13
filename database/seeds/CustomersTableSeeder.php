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
        \App\Models\Room::truncate();

        $branches = \App\Models\Branch::all();

        foreach ($branches as $branch) {
            for ($i=0; $i < rand(5,10) ; $i++) {
                $password = $faker->password;

                $user =  \App\Models\User::create([
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'username' => $faker->userName.$faker->userName,
                    'email' => $faker->email,
                    'password' => bcrypt($password),
                    'role_id' => 4,
                ]);

                $room = \App\Models\Room::create([
                    'room_number'   => rand(100, 999),
                    'room_hash'     => 'R'.$faker->randomNumber(6),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);

                \App\Models\Customer::create([
                    'name'      => $faker->name,
                    'address'   => $faker->address,
                    'status'    => 1,
                    'customer_password' => $password,
                    'avatar'    => $faker->image(public_path() . '/customer_avatars'),
                    'branch_id' => $branch->id,
                    'user_id'   => $user['id'],
                    'room_id'   => $room['id'],
                ]);
            }
        }
    }
}
