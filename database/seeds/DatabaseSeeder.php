<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
        // $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
=======
		DB::table('users')->insert([
            'company_name' =>'holipic',
            'first_name' => 'hoa_map',
            'last_name' => 'tran',
            'email' =>'tranduyhoa94@gmail.com',
            'password' => Hash::make('123465'),
            'access_token' => 'Wado4p88M8GwUk7aSi4v7LnAuokXbgnNJJ2fipzPzL7U4r2VjtuBItjherSErMbR',
            'package_id' => 1,
            'role_id' => 1,            
        ]);
>>>>>>> 9823f81593ee09ebc45d2075a9a0b37b91013d30
    }
}
