<?php

use Illuminate\Database\Seeder;

class ExchangeRatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        
        \App\Models\ExchangeRate::truncate();

        DB::table('exchange_rates')->insert([
        	[
                'from_currency_id' =>  1,
                'to_currency_id' =>  2,
                'rate' => (float) 0.87
        	],

        	[
                'from_currency_id' =>  1,
                'to_currency_id' =>  3,
                'rate' => (float) 14555.5
        	],

        	[
                'from_currency_id' =>  2,
                'to_currency_id' =>  3,
                'rate' =>(float)  16674.39
        	],

        	[
                'from_currency_id' =>  2,
                'to_currency_id' =>  1,
                'rate' => (float) 1.1455
        	],

        	[
                'from_currency_id' =>  3,
                'to_currency_id' =>  1,
                'rate' => (float) 0.0000687
        	],

        	[
                'from_currency_id' =>  3,
                'to_currency_id' =>  2,
                'rate' => (float) 0.0000599
        	],
        ]);
    }
}
