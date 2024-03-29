<?php

use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
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
        \App\Models\Room::truncate();
        
        // create rooms 
        for ($i=0; $i < 100 ; $i++) {
            $now = now();
            \App\Models\Room::create([
                'room_number'   => rand(100, 500),
                'room_hash'     => 'R'.$faker->randomNumber(6),
                'added_date'    => $now, 
                'updated_date'  => $now,
            ]);
        }
    }
}
