<?php

use Illuminate\Database\Seeder;
use\App\Models\Package;
class PackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	Package::truncate();

         $arrPackage = [
        	[
	        	'package_name' => 'Basic', 
	        	'short_description' => 'Secure file sharing and collaboration', 
	        	'fee' => 2.5, 
	        	'secure_storage' => 100, 
	        	'file_upload' => 2, 
	        	'minimum_user' => 3, 
	        	'max_user' => '10'
	        ],
        	[
	        	'package_name' => 'Pro', 
	        	'short_description' => 'More power & personalization', 
	        	'fee' => 3, 
	        	'secure_storage' => 'Unlimited', 
	        	'file_upload' => 5, 
	        	'minimum_user' => 3, 
	        	'max_user' => 'Unlimited'
	        ]
        ];

        foreach ($arrPackage as $key => $value) {

        	$package = Package::create([
        		'package_name' 		=> $value['package_name'],
		        'short_description' => $value['short_description'],
		        'fee'				=> $value['fee'],
		        'secure_storage'	=> $value['secure_storage'],
		        'file_upload'		=> $value['file_upload'],
		        'minimum_user'		=> $value['minimum_user'],
		        'max_user'			=> $value['max_user']
        	]);


        }
    }
}
