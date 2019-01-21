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
        Schema::disableForeignKeyConstraints();
        
        \App\Models\Currency::truncate();

        DB::table('currencies')->insert(
            [
            	[
                    'name' => 'United States Dollar',
                    'symbol' => '$',
                    'country' => 'United States of America'
            	],
            	[
                    'name' => 'European Euro',
                    'symbol' => '€',
                    'country' => 'European'
            	],
            	[
                    'name' => 'Indonesian Rupiah',
                    'symbol' => 'Rp',
                    'country' => 'Indonesia'
            	],
            ]
    	);
    }
}
