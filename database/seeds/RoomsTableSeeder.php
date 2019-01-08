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
        for ($i=1; $i < 20 ; $i++) {
            \App\Models\Room::create([
                'room_number' => $faker->randomNumber(1),
                'room_hash' => $faker->randomNumber(6),
            ]);
        }
    }
}
