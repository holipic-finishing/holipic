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
        DB::table('users')->insert([
            ['name' => 'sfr admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('12345'), 'role_id' => 1]
        ]);

    }
}
