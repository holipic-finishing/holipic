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
            ['first_name' => 'sfr','last_name' => 'company', 'company_name'=> 'SFR', 'email' => 'admin@gmail.com', 'password' => bcrypt('12345'), 'role_id' => 1, 'package_id' => 1]
        ]);
    }
}
