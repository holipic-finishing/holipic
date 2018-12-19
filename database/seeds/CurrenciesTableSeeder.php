<?php

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert(
        [
        	[
            'name' => 'Viet Nam Dong',
            'symbol' => 'VND',
            'country' => 'VietNamese'
        	],

        	[
            'name' => 'Australia dollar',
            'symbol' => '$',
            'country' => 'Australia'
        	],

        	[
            'name' => 'Andorra euro',
            'symbol' => '€',
            'country' => 'Andorra'
        	],

        ]
        	
    	);
    }
}
