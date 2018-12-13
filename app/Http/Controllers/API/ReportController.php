<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Repositories\TransactionRepository;
use App\Http\Controllers\API\BaseApiController;

class ReportController extends BaseApiController
{

	/** @var  TransactionRepository */
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactionRepository = $transactionRepo;
    }
    

	public function reportIncomesPackage(Request $request){

		$input = $request->all();

       	if($request->has(['start_day','end_day'])){

       		$arrayDay = $this->initDays($input['start_day'],$input['end_day']);

       		$report = $this->transactionRepository->reportUserDaily($input,$arrayDay);

       		return $this->responseSuccess('Data success',$report);
       	}

    }


    public function initDays($startDate, $endDate){
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        $data = [];
        $date = $startDate;
        while($date <= $endDate){
            $data[$date->toDateString()] = null;
            $date->addDays(1);
        }
        return $data;
    }
    public function initWeekDays(){
       $today = Carbon::today();
        $arrayWeek = [];
        for ($i=0; $i <=3 ; $i++) { 
            $arrayWeek[$i]['endOfWeek'] = Carbon::parse($today)->format('Y-m-d');
            $arrayWeek[$i]['startOfWeek'] = Carbon::parse($today)->subDays(6)->format('Y-m-d');
            $today = Carbon::parse($today)->subDays(7)->format('Y-m-d');
        }
        return $arrayWeek;
    }

}
