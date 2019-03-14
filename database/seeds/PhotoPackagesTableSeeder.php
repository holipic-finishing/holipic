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
                'company_id' => '1',
                'dollar' => 5.0,
                'euro' => 4.41876,
                'indo' => 70456.38,
                'turkey' => 26.4076,
                'vn' => 116111.66 
        	],
        	[
                'size' => 'DIGITAL',
                'price' => '150000',
                'free_photo' => '0',
                'currency_id' => '1',
                'company_id' => '1',
                'dollar' => 2.0,
                'euro' => 1.76761,
                'indo' => 28182.11,
                'turkey' => 10.5631,
                'vn' => 46516.63
        	],
        	[
                'size' => '10R',
                'price' => '300000',
                'free_photo' => '0',
                'currency_id' => '1',
                'company_id' => '1',
                'dollar' => 4.0,
                'euro' => 3.53531,
                'indo' => 56364.98,
                'turkey' => 21.1269,
                'vn' => 92836.95 
        	],
        	[
                'size' => '6R',
                'price' => '150000',
                'free_photo' => '0',
                'currency_id' => '1',
                'company_id' => '1',
                'dollar' => 2.0,
                'euro' => 1.76761,
                'indo' => 28182.11,
                'turkey' => 10.5631,
                'vn' => 46516.63
        	],
        	[
                'size' => '4R',
                'price' => '150000',
                'free_photo' => '0',
                'currency_id' => '1',
                'company_id' => '1',
                'dollar' => 2.0,
                'euro' => 1.76761,
                'indo' => 28182.11,
                'turkey' => 10.5631,
                'vn' => 46516.63
        	],
        	[
                'size' => 'FRAME',
                'price' => '250000',
                'free_photo' => '1',
                'currency_id' => '1',
                'company_id' => '1',
                'dollar' => 3.0,
                'euro' => 2.65142,
                'indo' => 42273.16,
                'turkey' => 15.8452,
                'vn' => 69627.71
        	],
        ]
    	);
    }
}
