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
                'from_currency_id' =>  2,
                'to_currency_id' =>  1,
                'rate' => (float) 1.1455
        	],

        	[
                'from_currency_id' =>  3,
                'to_currency_id' =>  1,
                'rate' => (float) 0.0000687
        	],

        ]);
    }
}
