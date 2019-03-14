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
	        	'price' => 70456.38, 
	        	'offer' => 60456.38, 
	        	'total_photo' => 21, 
	        	'album' => 'Mini Album', 
	        	'photo_on_disc' => 21,
	        	'poster' => null,
	        	'company_id' => '1',
	        	'dollar' => 5.0,
	        	'euro' => 4.41876,
	        	'indo' => 70456.38,
	        	'turkey' => 26.4076,
	        	'vn' => 116111.66 
	        ],
	        [
	        	'package_name' => 'Package 2', 
	        	'price' => 56364.98, 
	        	'offer' => 46364.98, 
	        	'total_photo' => 30, 
	        	'album' => '1 Photobook', 
	        	'photo_on_disc' => 30,
	        	'poster' => 1,
	        	'company_id' => '1',
	        	'dollar' => 4.0,
	        	'euro' => 3.53531,
	        	'indo' => 56364.98,
	        	'turkey' => 21.1269,
	        	'vn' => 92836.95 
	        ],
	        [
	        	'package_name' => 'Package 3', 
	        	'price' => 42273.16, 
	        	'offer' => 32273.16, 
	        	'total_photo' => 40, 
	        	'album' => 'Handmade Album', 
	        	'photo_on_disc' => 40,
	        	'poster' => 2,
	        	'company_id' => '1',
	        	'dollar' => 3.0,
	        	'euro' => 2.65142,
	        	'indo' => 42273.16,
	        	'turkey' => 15.8452,
	        	'vn' => 69627.71
	        ],
	        [
	        	'package_name' => 'Package 4', 
	        	'price' => 28182.11, 
	        	'offer' => 18182.11, 
	        	'total_photo' => 50, 
	        	'album' => 'Large Album', 
	        	'photo_on_disc' => 50,
	        	'poster' => 2,
	        	'company_id' => '2',
	        	'dollar' => 2.0,
	        	'euro' => 1.76761,
	        	'indo' => 28182.11,
	        	'turkey' => 10.5631,
	        	'vn' => 46516.63
	        ],
	        [
	        	'package_name' => 'Package 5', 
	        	'price' => 14091.13, 
	        	'offer' => 14091.13, 
	        	'total_photo' => 50, 
	        	'album' => 'Big Album', 
	        	'photo_on_disc' => 50,
	        	'poster' => 2,
	        	'company_id' => '2',
	        	'dollar' => 1.0,
	        	'euro' => 0.883823,
	        	'indo' => 14091.13,
	        	'turkey' => 5.28137,
	        	'vn' => 23258.32
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
		        'dollar' => $value['dollar'],
	        	'euro' => $value['euro'],
	        	'indo' => $value['indo'],
	        	'turkey' => $value['turkey'],
	        	'vn' => $value['vn']
        	]);
        }
    }
}
