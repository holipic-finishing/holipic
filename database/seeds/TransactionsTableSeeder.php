<?php

use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactions')->insert(
        [
        	[
	            'user_id' => 1,
	            'type' => '1', //incomece
	            'currency_id' => '1',
	            'amount' => 6500,
	            'status' => 'completed',
	            'company_id' => 1,
	            'dated' => '2018-12-11'
        	],

        	[
	            'user_id' => 1,
	            'type' => '1', //incomece
	            'currency_id' => '1',
	            'amount' => 3400,
	            'status' => 'completed',
	            'company_id' => 1,
	            'dated' => '2018-12-11'
        	],

            [
                'user_id' => 1,
                'type' => '1', //incomece
                'currency_id' => '1',
                'amount' => 4000,
                'status' => 'completed',
                'company_id' => 1,
                'dated' => '2018-12-9'
            ],

            [
                'user_id' => 1,
                'type' => '1', //incomece
                'currency_id' => '1',
                'amount' => 1800,
                'status' => 'completed',
                'company_id' => 1,
                'dated' => '2018-11-30'
            ],

        ]
        	
    	);
    }
}
