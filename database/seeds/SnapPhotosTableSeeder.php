<?php

use Illuminate\Database\Seeder;

class SnapPhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker\Factory::create();

    	\App\Models\SnapPhotoDetail::truncate();

    	$room = \App\Models\Room::all()->random(1)->first();

        $snapPhoto = \App\Models\SnapPhoto::create([
        	'branch_id' => 2,
        	'photographer_id' => 7,
        	'room_id' => $room['id']
        ]);

        for($i=0; $i<=3; $i++)
        {
        	\App\Models\SnapPhotoDetail::create([
        	 	'snap_photo_id' => $snapPhoto['id'],
		        'image_resize' => $faker->image(public_path() .'/room/photos'),
		        'image_final' => $faker->image(public_path() .'/room/photos'),
		        'is_booking' => false
        	]);
        }
    }
}
