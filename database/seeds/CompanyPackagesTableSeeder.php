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
        CompanyPackage::truncate();

         $arrPackage = [
        	[
	        	'package_name' => 'Package 1', 
	        	'price' => 'Rp 3000000', 
	        	'offer' => 'Rp 2500000', 
	        	'detail' => '21 photos 4R Print
							Mini Album
							21 photos on the disc', 
	        ],
	        [
	        	'package_name' => 'Package 2', 
	        	'price' => 'Rp 4500000', 
	        	'offer' => 'Rp 3500000', 
	        	'detail' => '30 photos Print
							1 Photobook
							30 photos on the disc
							1 Poster (20x30)', 
	        ],
	        [
	        	'package_name' => 'Package 3', 
	        	'price' => 'Rp 6000000', 
	        	'offer' => 'Rp 4500000', 
	        	'detail' => '40 photos 4R Print
							Handmade Album
							40 photos on the disc
							2 Poster (20x30)', 
	        ],
	        [
	        	'package_name' => 'Package 4', 
	        	'price' => 'Rp 7500000', 
	        	'offer' => 'Rp 6000000', 
	        	'detail' => '50 Print
							Large Album
							50 photos on the disc
							2 Poster (20x30)', 
	        ],
        ];

        foreach ($arrPackage as $key => $value) {

        	$package = CompanyPackage::create([
        		'package_name'    => $value['package_name'],
		        'price'   => $value['price'],
		        'offer'   => $value['offer'],
		        'detail'  => $value['detail']
        	]);
        }
    }
}
