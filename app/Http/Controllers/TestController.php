<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\File;
use App\Models\Package;
use App\Models\Setting;

class TestController extends Controller
{
	public function test(){

		$expiration_date = 0;

		$resultes = Setting::all();

		foreach ($resultes as $key => $item) {
			
			$setting = Setting::select('expiration_date')->where('id',$item->id)->first()->toArray();

			$expiration_date = $setting['expiration_date'];

			$day = \Carbon\Carbon::now()->subDay($expiration_date);

			$package_id = $item->id;

			$resultes = File::whereHas('user' , function($query) use ($package_id){
								$query->where('package_id','=',$package_id);
						})->whereDate('uploaded_date','<',$day)->where('status','1')->get();

			// dd(count($resultes));
			foreach ($resultes as $key => $value) {
				$data = File::where('id',$value->id)->update([
							'status' => '0'
						]);
			}

		}

		

	}    
}
