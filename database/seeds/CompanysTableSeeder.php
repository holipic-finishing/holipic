<?php

use Illuminate\Database\Seeder;

class CompanysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      	 DB::table('companies')->insert([
            'name' => 'sfr',
            'description' => 'IT software company',
            'address' => '1331 Nguyen Tat Thanh Da Nang',
            'owner_id' => '2',
            'logo' => 'blabla.jpg'
        ]);
    }
}
