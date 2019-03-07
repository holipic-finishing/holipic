<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimezonesTableSeeder extends Seeder
{
	/**
	* Run the database seeds.
	*
	* @return void
	*/
	public function run()
	{
		$timezones = file_get_contents('http://api.timezonedb.com/v2.1/list-time-zone?key=OTBTPYENE9KL&format=json');

		$json = json_decode($timezones);

		foreach($json->zones as $value) 
		{
			\DB::table('timezones')->insert([
			'country_code' => $value->countryCode,
			'country_name' => $value->countryName,
			'zone_name' => $value->zoneName,
			'gmt_offset'=> $value->gmtOffset,
			'timestamp' => $value->timestamp
			]);
		}
	}
}