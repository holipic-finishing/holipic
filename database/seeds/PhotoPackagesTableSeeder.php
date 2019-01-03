<?php

use Illuminate\Database\Seeder;

class PhotoPackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('photo_packages')->insert(
        [
        	[
            'size' => 'Photo Slate',
            'price' => '500000',
            'free_photo' => '0',
            'currency_id' => '1',
        	],
        	[
            'size' => 'DIGITAL',
            'price' => '150000',
            'free_photo' => '0',
            'currency_id' => '1',
        	],
        	[
            'size' => '10R',
            'price' => '300000',
            'free_photo' => '0',
            'currency_id' => '1',
        	],
        	[
            'size' => '6R',
            'price' => '150000',
            'free_photo' => '0',
            'currency_id' => '1',
        	],
        	[
            'size' => '4R',
            'price' => '150000',
            'free_photo' => '0',
            'currency_id' => '1',
        	],
        	[
            'size' => 'FRAME',
            'price' => '250000',
            'free_photo' => '1',
            'currency_id' => '1',
        	],
        ]
    	);
    }
}
