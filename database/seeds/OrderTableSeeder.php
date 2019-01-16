<?php

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        
        \App\Models\Order::truncate();

        \App\Models\OrderExchange::truncate();

        $faker = Faker\Factory::create();

        $branches = \App\Models\Branch::all();

        $list_branch_id = [] ;

        foreach ($branches as $key => $branch) {
        	array_push($list_branch_id ,$branch->id);
        }

        $payment_method = ['CC', 'CASH'];

        $purchase_from = ['WEB', 'SHOP'];

        $status = ['PENDING', 'DONE', 'CANCEL'];

        $list_currency_id = [1,2,3];

        $list_total_amount_dollar = [10, 15 , 30, 45] ;
        $list_total_amount_euro = [8, 14 , 28, 42] ;
        $list_total_amount_rp = [150000, 250000 , 600000, 900000] ;

        for($i=0; $i < 5000 ; $i++){

        	$dated =  $faker->dateTimeBetween($startDate = '-15 months', $endDate = '+1months', $timezone = null);

        	$purchase_from_select = $faker->randomElement($purchase_from);

        	$status_select = $faker->randomElement($status);

        	$currency_id = $faker->randomElement($list_currency_id);

        	if($currency_id == 1 ){
        		$total_amount = $faker->randomElement($list_total_amount_dollar);
        	}
        	if($currency_id == 2 ){
        		$total_amount = $faker->randomElement($list_total_amount_euro);
        	}
        	if($currency_id == 3 ){
        		$total_amount = $faker->randomElement($list_total_amount_rp);
        	}

	        if($purchase_from_select == 'WEB'){
	        	if($status_select != 'DONE'){
	        		$payment_method_select = 'WEB';
		        	$purchase_date = null;
		        	$download_date =  null;
		        	$order_date = $dated;
	        	}else{
		        	$payment_method_select = 'WEB';
		        	$purchase_date = $dated;
		        	$download_date =  $dated;
		        	$order_date = $dated;
	        	}
	        }
	        if($purchase_from_select == 'SHOP'){
	        	if($status_select != 'DONE'){
		        	$payment_method_select = $faker->randomElement($payment_method);
		        	$purchase_date = null;
		        	$download_date = null;
		        	$order_date = $dated;
	        	}else{
	        		$payment_method_select = $faker->randomElement($payment_method);
		        	$purchase_date = $dated;
		        	$download_date = null;
		        	$order_date = $dated;
	        	}
	        }
	       
	        $branch_id = $faker->randomElement($list_branch_id);

	        // photographer
	        $photographers = \App\Models\Photographer::where('branch_id',$branch_id)->get();

	        $list_photograher_id = [];

	        foreach ($photographers as $key => $photographer) {
	        	array_push($list_photograher_id ,$photographer->id);
	        }

	        $photographer_id = $faker->randomElement($list_photograher_id);

	        //customer

	        $customers = \App\Models\Customer::where('branch_id',$branch_id)->get();

	        $list_customer_id = [];

	        foreach ($customers as $key => $customer) {
	        	array_push($list_customer_id ,$customer->id);
	        }

	        $customer_id = $faker->randomElement($list_customer_id);

	       
	       $order = new Order();
	       $order->branch_id = $branch_id;
	       $order->photographer_id = $photographer_id;
	       $order->customer_id = $customer_id;
	       $order->total_amount = $total_amount;
	       $order->purchase_date = $purchase_date;
	       $order->download_date = $download_date;
	       $order->payment_method = $payment_method_select;
	       $order->purchase_from = $purchase_from_select;
	       $order->status = $status_select;
	       $order->invoice = 'INV'.$faker->ean8;
	       $order->currency_id = $currency_id;
	       $order->created_at = $order_date;
	       $order->save();

        }
                
    }
    
}
