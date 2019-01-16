<?php

use Illuminate\Database\Seeder;
use\App\Models\CompanyPackage;

class CompanyPackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Schema::disableForeignKeyConstraints();
        CompanyPackage::truncate();

        $arrPackage = [
        	[
	        	'package_name' => 'Package 1', 
	        	'price' => 'Rp 3000000', 
	        	'offer' => 'Rp 2500000', 
	        	'total_photo' => 21, 
	        	'album' => 'Mini Album', 
	        	'photo_on_disc' => 21,
	        	'poster' => null,
	        	'company_id' => '1',
	        ],
	        [
	        	'package_name' => 'Package 2', 
	        	'price' => 'Rp 4500000', 
	        	'offer' => 'Rp 3500000', 
	        	'total_photo' => 30, 
	        	'album' => '1 Photobook', 
	        	'photo_on_disc' => 30,
	        	'poster' => 1,
	        	'company_id' => '1', 
	        ],
	        [
	        	'package_name' => 'Package 3', 
	        	'price' => 'Rp 6000000', 
	        	'offer' => 'Rp 4500000', 
	        	'total_photo' => 40, 
	        	'album' => 'Handmade Album', 
	        	'photo_on_disc' => 40,
	        	'poster' => 2,
	        	'company_id' => '1',  
	        ],
	        [
	        	'package_name' => 'Package 4', 
	        	'price' => 'Rp 7500000', 
	        	'offer' => 'Rp 6000000', 
	        	'total_photo' => 50, 
	        	'album' => 'Large Album', 
	        	'photo_on_disc' => 50,
	        	'poster' => 2,
	        	'company_id' => '2', 
	        ],
	        [
	        	'package_name' => 'Package 5', 
	        	'price' => 'Rp 7500000', 
	        	'offer' => 'Rp 6000000', 
	        	'total_photo' => 50, 
	        	'album' => 'Big Album', 
	        	'photo_on_disc' => 50,
	        	'poster' => 2,
	        	'company_id' => '2', 
	        ],
        ];

        foreach ($arrPackage as $key => $value) {

        	$package = CompanyPackage::create([
        		'package_name'    => $value['package_name'],
		        'price'   => $value['price'],
		        'offer'   => $value['offer'],
		        'total_photo'  => $value['total_photo'],
		        'album'  => $value['album'],
		        'photo_on_disc'  => $value['photo_on_disc'],
		        'poster'  => $value['poster'],
		        'company_id'  => $value['company_id'],
        	]);
        }
    }
}
