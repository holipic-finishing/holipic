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
<<<<<<< HEAD
        DB::table('users')->insert([
            ['name' => 'sfr admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('12345'), 'role_id' => 1]
        ]);

=======
        //
>>>>>>> 9823f81593ee09ebc45d2075a9a0b37b91013d30
    }
}
