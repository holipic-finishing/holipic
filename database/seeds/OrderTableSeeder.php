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

        $faker = Faker\Factory::create();

        $branches = \App\Models\Branch::all();

        $list_branch_id = [] ;

        foreach ($branches as $key => $branch) {
        	array_push($list_branch_id ,$branch->id);
        }

        $payment_method = ['CC', 'CASH'];

        $purchase_from = ['WEB', 'SHOP'];

        $status = ['PENDING', 'DONE', 'CANCEL'];


        for($i=0; $i <= 500 ; $i++){

        	$purchase_from_select = $faker->randomElement($purchase_from);

	        if($purchase_from_select == 'WEB'){
	        	$dated =  $faker->dateTimeBetween($startDate = '-6 months', $endDate = '+8 months', $timezone = null);
	        	$payment_method_select = 'WEB';
	        	$purchase_date = $dated;
	        	$download_date =  $dated;
	        }
	        if($purchase_from_select == 'SHOP'){
	        	$dated =  $faker->dateTimeBetween($startDate = '-6 months', $endDate = '+8 months', $timezone = null);
	        	$payment_method_select = $faker->randomElement($payment_method);
	        	$purchase_date = $dated;
	        	$download_date = null;
	        }
	       
	        $branch_id = $faker->randomElement($list_branch_id);


	        // photographer
	        $photographers = \App\Models\Photographer::where('branch_id',$branch_id)->get();

	        $list_photograher_id = [];

	        foreach ($photographers as $key => $photographer) {
	        	array_push($list_photograher_id ,$photographer->id);
	        }

	        $photographer_id = $faker->randomElement($list_photograher_id);

	        //cuatomer

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
	       $order->total_amount = $faker->randomFloat(2);
	       $order->purchase_date = $purchase_date;
	       $order->download_date = $download_date;
	       $order->payment_method = $payment_method_select;
	       $order->purchase_from = $purchase_from_select;
	       $order->status = $faker->randomElement($status);
	       $order->invoice = 'INV'.time();

	       $order->save();

	        // $order = \App\Models\Order::create([
         //        'branch_id' => $branch_id,
         //        'photographer_id' => $photographer_id,
         //        'customer_id' => $customer_id,
         //        'total_amount' =>  $faker->randomFloat(2),
         //        'purchase_date' => $purchase_date,
         //        'download_date' => $download_date,
         //        'payment_method' => $payment_method,
         //        'purchase_from' => $purchase_from,
         //        'status' => $faker->randomElement($status),
         //        'invoice'=> 'INV'.time(),
                
         //    ]);


        }
                
    }
    
}

