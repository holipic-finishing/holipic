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
	            'currency_id' => '3',
	            'amount' => 50000,
	            'status' => 'completed',
	            'company_id' => 1,
	            'dated' => '2018-12-10'
        	],

        	[
	            'user_id' => 1,
	            'type' => '1', //incomece
	            'currency_id' => '3',
	            'amount' => 50000,
	            'status' => 'completed',
	            'company_id' => 1,
	            'dated' => '2018-12-11'
        	],

            [
                'user_id' => 1,
                'type' => '1', //incomece
                'currency_id' => '3',
                'amount' => 4000,
                'status' => 'completed',
                'company_id' => 1,
                'dated' => '2018-12-1'
            ],

            [
                'user_id' => 1,
                'type' => '1', //incomece
                'currency_id' => '3',
                'amount' => 9000,
                'status' => 'completed',
                'company_id' => 1,
                'dated' => '2018-12-4'
            ],

        ]
        	
    	);
    }
}
