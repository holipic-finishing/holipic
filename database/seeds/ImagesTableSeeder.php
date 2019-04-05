<?php

use Illuminate\Database\Seeder;
use Intervention\Image\ImageManagerStatic as Image;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        \App\Models\Image::truncate();

        $faker = Faker\Factory::create();

        $listings = \App\Models\Listing::with('room')->get();

        $categories = array(
	        'abstract', 'business', 'nightlife', 'fashion', 'people', 'nature', 'sports', 'technics'
	    );

        foreach ($listings as $listing) {

        	$room_folder_name = $listing->room->room_hash;
        	$path = storage_path() . '/images/' . $room_folder_name;
        	
        	if (!file_exists($path)) {
	            File::makeDirectory($path . '/compressed', $mode = 0777, true, true);
	            File::makeDirectory($path . '/original', $mode = 0777, true, true);
	        }

        	for ($i=0; $i < rand(80, 100); $i++) {

        		$original_img = $faker->image($path . '/original', 1920, 1080, $faker->randomElement($categories), false);

        		Image::configure(array('driver' => 'imagick'));
        		$compressed_img = Image::make($path . '/original/' . $original_img);
        		$compressed_img->resize(640, 480);
        		$compressed_img->insert(public_path() . '/images/watermark.png', 'center');
        		$compressed_img->encode('data-url');
        		$compressed_img->save($path . '/compressed/' . 'thumbnail_' . $original_img, 70);
        		
        		\App\Models\Image::create([
        			'filename' => $original_img,
        			'img_type' => 'ORIGINAL',
        			'is_booking' => 0,
        			'listing_id' => $listing->id
        		]);

        		\App\Models\Image::create([
        			'filename' => 'thumbnail_' . $original_img,
        			'img_type' => 'COMPRESSED',
        			'is_booking' => 0,
        			'listing_id' => $listing->id
        		]);
        	}
        }
    }
}
