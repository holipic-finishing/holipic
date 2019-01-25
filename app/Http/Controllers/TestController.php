<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\File;
use App\Models\Package;
use App\Models\Setting;
use App\Services\PayPalService as PayPalSvc;

class TestController extends Controller
{
	private $paypalSvc;

    public function __construct(PayPalSvc $paypalSvc)
    {
        $this->paypalSvc = $paypalSvc;
    }


    public function index(){
    	$data = [
            [
                'name' => 'Vinataba',
                'quantity' => 1,
                'price' => 1.5,
                'sku' => '1'
            ],
            [
                'name' => 'Marlboro',
                'quantity' => 1,
                'price' => 1.6,
                'sku' => '2'
            ],
            [
                'name' => 'Esse',
                'quantity' => 1,
                'price' => 1.8,
                'sku' => '3'
            ]
        ];
        $transactionDescription = "Tobaco";

        $paypalCheckoutUrl = $this->paypalSvc
                                  ->setReturnUrl(url('paypal/status'))
                                  ->setItem($data)
                                  ->createPayment($transactionDescription);

        if ($paypalCheckoutUrl) {
            return redirect($paypalCheckoutUrl);
        } else {
            dd(['Error']);
        }
    }

    public function status()
    {
        $paymentStatus = $this->paypalSvc->getPaymentStatus();
        dd($paymentStatus);
    }

    public function paymentList()
    {
        $limit = 10;
        $offset = 0;

        $paymentList = $this->paypalSvc->getPaymentList($limit, $offset);

        dd($paymentList);
    }

    public function paymentDetail(Request $requset)
    {
    	$input = $requset->all();

        $paymentDetails = $this->paypalSvc->getPaymentDetails($input['paymentId']);

        dd($paymentDetails);
    }
	// public function test(){

	// 	$expiration_date = 0;

	// 	$resultes = Setting::all();

	// 	foreach ($resultes as $key => $item) {
			
	// 		$setting = Setting::select('expiration_date')->where('id',$item->id)->first()->toArray();

	// 		$expiration_date = $setting['expiration_date'];

	// 		$day = \Carbon\Carbon::now()->subDay($expiration_date);

	// 		$package_id = $item->id;

	// 		$resultes = $this->arrayFileRemove($package_id,$day);

	// 		$this->updateStatusFile($resultes);

	// 	}

	// } 

	// public function arrayFileRemove($package_id,$day) {

	// 	$resultes = File::whereHas('user' , function($query) use ($package_id){
	// 							$query->where('package_id','=',$package_id);
	// 					})->whereDate('uploaded_date','<',$day)->where('status','1')->get();

	// 	return $resultes;

	// } 

	// public function updateStatusFile($attribute){
		
	// 	if(count($attribute) !=0){
	// 		foreach ($attribute as $key => $value) {
	// 			$data = File::where('id',$value->id)->update([
	// 						'status' => '0'
	// 					]);
	// 		}
	// 		return true;

	// 	} else {

	// 		return false;
	// 	}

		

	// }
}
