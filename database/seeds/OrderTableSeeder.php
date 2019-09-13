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
        \App\Models\Transaction::truncate();
        \App\Models\TransactionExchange::truncate();
        \App\Models\TransactionCalulatorEwallet::truncate();

        $faker = Faker\Factory::create();
        $list_currency_id       = \App\Models\Currency::all()->pluck('id')->toArray();

        // get all booking
        $bookings = \App\Models\Booking::all();

        foreach ($bookings as $booking) {

        	$photographer = \App\Models\Photographer::with('branch')->where('id', $booking->photographer_id)->first();

        	\App\Models\Order::create([
        		'branch_id' 		=> $photographer->branch->id,
		       	'photographer_id' 	=> $booking->photographer_id,
		       	'customer_id' 		=> $booking->customer_id,
		       	'total_amount' 		=> null,
		       	'purchase_date' 	=> null,
		       	'download_date' 	=> null,
		       	'payment_method' 	=> null,
		       	'purchase_from' 	=> null,
		       	'status' 			=> 'BOOKING',
		       	'invoice' 			=> null,
		       	'currency_id' 		=> $faker->randomElement($list_currency_id),
		       	'created_at' 		=> $faker->dateTimeBetween($startDate = '-1 months', $endDate = 'now'),
        	]);
        }

        $list_package_id 		= \App\Models\CompanyPackage::all()->pluck('id')->toArray();
        $list_photo_package_id 	= \App\Models\PhotoPackage::all()->pluck('id')->toArray();

        $payment_method = ['CC', 'CASH'];
        $purchase_from 	= ['ONLINE', 'SHOP'];
        $status 		= ['CANCEL', 'DONE', 'PAID'];

        $list_total_amount_dollar 	= [10, 15, 30, 45, 60] ;
        $list_total_amount_euro 	= [8, 14, 28, 42] ;
        $list_total_amount_rp 		= [150000, 250000 , 600000, 900000] ;

        /**
         * $check = 1 is choose package list
         * $check = 2 is choose photo package
         */
        $check = $faker->numberBetween(1,2);
    
        for($i=0; $i < 600 ; $i++){
        	//random date
        	$dated =  $faker->dateTimeBetween($startDate = '-3 months', $endDate = '+3 months');

        	$currency_id = $faker->randomElement($list_currency_id);

        	switch ($currency_id) {
        		case 1:
        			$total_amount = $faker->randomElement($list_total_amount_dollar);
        			break;
        		case 2:
        			$total_amount = $faker->randomElement($list_total_amount_euro);
        			break;
        		
        		default:
        			$total_amount = $faker->randomElement($list_total_amount_rp);
        			break;
        	}

        	$purchase_from_select = $faker->randomElement($purchase_from);
        	$status_select = $faker->randomElement($status);

		    if ($status_select == 'CANCEL') {

		    	$payment_method_select 	= null;
	        	$purchase_date 			= null;
	        	$download_date 			= null;
	        	$order_date 			= null;
		    } else {

	        	$purchase_date 			= $dated;
	        	$download_date 			= $dated;
	        	$order_date 			= $dated;
		        
		        if($purchase_from_select == 'ONLINE'){

		        	$payment_method_select 	= 'ONLINE';
		        }

		        if($purchase_from_select == 'SHOP'){

	        		$payment_method_select 	= $faker->randomElement($payment_method);
		        }
		    }
	       
	       	// get branches
	        $list_branch_id = \App\Models\Branch::all()->pluck('id')->toArray();
	        $branch_id = $faker->randomElement($list_branch_id);

	        // photographers
	        $list_photograher_id = \App\Models\Photographer::where('branch_id',$branch_id)->get()->pluck('id')->toArray();
	        $photographer_id = $faker->randomElement($list_photograher_id);

	        //customers
	        $list_customer_id = \App\Models\Customer::where('branch_id',$branch_id)->get()->pluck('id')->toArray();
	        $customer_id = $faker->randomElement($list_customer_id);

	       
	       	$order = new Order();
	       	$order->branch_id 		= $branch_id;
	       	$order->photographer_id = $photographer_id;
	       	$order->customer_id 	= $customer_id;
	       	$order->total_amount 	= $total_amount;
	       	$order->purchase_date 	= $purchase_date;
	       	$order->download_date 	= $download_date;
	       	$order->payment_method 	= $payment_method_select;
	       	$order->purchase_from 	= $purchase_from_select;
	       	$order->status 			= $status_select;
	       	$order->invoice 		= 'INV' . time() . rand(1000000, 9999999);
	       	$order->currency_id 	= $currency_id;
	       	$order->created_at 		= $order_date;
	       	$order->save();
        }         
    }
    
}

