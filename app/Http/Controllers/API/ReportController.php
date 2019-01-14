<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Repositories\TransactionRepository;
use App\Repositories\OrderRepository;
use App\Http\Controllers\API\BaseApiController;

class ReportController extends BaseApiController
{

	/** @var  TransactionRepository */
    private $transactionRepository;
    private $orderRepository;

    public function __construct(TransactionRepository $transactionRepo, OrderRepository $orderRepo)
    {
        $this->transactionRepository = $transactionRepo;
        $this->orderRepository = $orderRepo;
    }
    

	  public function reportIncomesPackage(Request $request){

		 $input = $request->all();
        // report from day, to day
       	if($request->has(['start_day','end_day'])){

       		$arrayDay = $this->initDays($input['start_day'],$input['end_day']);

       		$report = $this->transactionRepository->reportTransactionrDaily($input,$arrayDay);

       		return $this->responseSuccess('Data success',$report);

       	} else 
        // report from month, to month 
          if($request->has(['start_month','end_month'])){

         		$arrayInMonth = $this->initInMonth($input['start_month'],$input['end_month']);

         		$report = $this->transactionRepository->reportTransactionMonth($input,$arrayInMonth);

         		return $this->responseSuccess('Data success',$report);

       	} else 
        // report year
          if($request->has(['start_year','end_year'])){

         		$arrayMonthInYear = $this->initYear($input['start_year'],$input['end_year']);
         		
         		$report = $this->transactionRepository->reportTransactionYear($input,$arrayMonthInYear);

         		return $this->responseSuccess('Data success',$report);

       	} else 
        // report week
          if($request->has(['start_day_week','end_day_week'])){

            $arrayWeek = $this->initDayWeekDays($input['start_day_week'],$input['end_day_week']);

            $report = $this->transactionRepository->reportTransactionWeek($input,$arrayWeek);

            return $this->responseSuccess('Data success',$report);

        } else 
          // report default week
          if ($request->has(['defaultWeek'])) {

         		$arrayWeek = $this->initWeekDays();

         		$report = $this->transactionRepository->reportTransactionWeek($input,$arrayWeek);

         		return $this->responseSuccess('Data success',$report);

       	} else 
          // report default 7 days 
          if($request->has(['defaultDay'])){

            $startDay   = Carbon::today()->subDays(7)->format('Y-m-d');

            $endDay     = Carbon::today()->format('Y-m-d');

            $arrayDay = $this->initDays($startDay,$endDay);

            $report = $this->transactionRepository->reportTransactionrDaily($input,$arrayDay);

            return $this->responseSuccess('Data success',$report);
       
        } else 
          // report default 12 month
          if($request->has(['defaultMonth'])){

            $startMonth  = Carbon::today()->subMonth(12)->format('Y-m-d');

            $endMonth    = Carbon::today()->format('Y-m-d');

            $arrayMonth = $this->initInMonth($startMonth,$endMonth);

            $report = $this->transactionRepository->reportTransactionMonth($input,$arrayMonth);

            return $this->responseSuccess('Data success',$report);

          }  else 

          if($request->has(['defaultYear'])){

            $startYear  = Carbon::today()->subYears(2)->format('Y-m');

            $endYear    = Carbon::today()->format('Y-m');

            $arrayYear = $this->initYear($startYear,$endYear);

            $report = $this->transactionRepository->reportTransactionYear($input,$arrayYear);

            return $this->responseSuccess('Data success',$report);

          }

        else
        {

       		return $this->responseError('Failed!', [
                'error' => 'Data not found',
            ],500);
       	}
       

    }


    public function initMonthInYear($year){

    	$timeYear = explode("-", $year);

    	$data = [];
        $date = 1;
        while($date <= 12){
        	if($date < 10) {
        		$key = $timeYear[0]."-0".$date;
        	}else {
        		$key = $timeYear[0]."-".$date;
        	}
        	
            $data[$key] = null;
            $date++;
        }
        return $data;

    }

    public function initDayInMonth($month){
    
    	$endInMonth = Carbon::parse($month)->endOfMonth();
    	$data = [];
        $date = Carbon::parse($month);
        while($date <= $endInMonth){
            $data[$date->toDateString()] = null;
            $date->addDays(1);
        }
        return $data;
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
        for ($i=0; $i <=6 ; $i++) { 
            $arrayWeek[$i]['endOfWeek'] = Carbon::parse($today)->format('Y-m-d');
            $arrayWeek[$i]['startOfWeek'] = Carbon::parse($today)->subDays(6)->format('Y-m-d');
            $today = Carbon::parse($today)->subDays(7)->format('Y-m-d');
        }
        return $arrayWeek;
    }

    public function initInMonth($from_month,$to_month){
        $start_month = Carbon::parse($from_month);
        $end_month = Carbon::parse($to_month);
        $data = [];
        $date = $start_month;
        while($date <= $end_month){
            $data[$date->format('Y-m')] = null;
            $date->addMonth(1);
        }
        return $data;
    }

    public function initYear($from_year, $to_year){
        $start_year = Carbon::parse($from_year);
        $end_year = Carbon::parse($to_year);
        $data = [];
        $date = $start_year;
        while($date <= $end_year){
            $data[$date->format('Y')] = null;
            $date->addYear(1);
        }
        return $data;
    }

    public function initDayWeekDays($start_day_week,$end_day_week){

        $start_day_week = Carbon::parse($start_day_week);
        $end_day_week = Carbon::parse($end_day_week);
        $arrayWeek = [];
        $week = $start_day_week->diffInWeeks($end_day_week);

         for ($i=0; $i <= $week ; $i++) { 
            $arrayWeek[$i]['startOfWeek'] = Carbon::parse($start_day_week)->format('Y-m-d');
            $arrayWeek[$i]['endOfWeek'] = Carbon::parse($start_day_week)->addDays(6)->format('Y-m-d');
            $start_day_week = Carbon::parse($start_day_week)->addDays(7)->format('Y-m-d');
         }
          $data = array_reverse($arrayWeek);
         return $data;
    }


    /**
     *
     * function to get infomation in order table (status is Done) to sale chart in company-admin  
     *@param : defaultDay or defaultWeek or defaultMonth or defaultYear
     */
    
    public function getInfoForChartCompanyAdmin(Request $request){
        $input = $request->all();
        // report from day, to day
        if(isset($input['type'])){
            $type = $input['type'];
            if($type == 'day'){
                $arrayDay = [];
                if(isset($input['start_day'],$input['end_day'])){
                  $arrayDay = $this->initDays($input['start_day'],$input['end_day']);
                }
                $report = $this->orderRepository->reportSaleDaily($input,$arrayDay);

                return $this->responseSuccess('Data success',$report);
            }
            
            if($type == 'month'){
              dd('month');
            }
            if($type == 'year'){
              dd('year');
            }
            if($type == 'week'){
              dd('week');
            }
        }
        if($request->has(['start_day','end_day'])){

          $arrayDay = $this->initDays($input['start_day'],$input['end_day']);

          $report = $this->orderRepository->reportSaleDaily($input,$arrayDay);

          return $this->responseSuccess('Data success',$report);

        } else 
        // report from month, to month 
          if($request->has(['start_month','end_month'])){

            $arrayInMonth = $this->initInMonth($input['start_month'],$input['end_month']);

            $report = $this->orderRepository->reportSaleMonth($input,$arrayInMonth);

            return $this->responseSuccess('Data success',$report);

        } else 
        // report year
          if($request->has(['start_year','end_year'])){

            $arrayMonthInYear = $this->initYear($input['start_year'],$input['end_year']);
            
            $report = $this->orderRepository->reportSaleYear($input,$arrayMonthInYear);

            return $this->responseSuccess('Data success',$report);

        } else 
        // report week
          if($request->has(['start_day_week','end_day_week'])){

            $arrayWeek = $this->initDayWeekDays($input['start_day_week'],$input['end_day_week']);

            $report = $this->orderRepository->reportSaleWeek($input,$arrayWeek);

            return $this->responseSuccess('Data success',$report);

        } else 
          // report default week
          if ($request->has(['defaultWeek'])) {

            $arrayWeek = $this->initWeekDays();

            $report = $this->orderRepository->reportSaleWeek($input,$arrayWeek);

            return $this->responseSuccess('Data success',$report);

        } else 
          // report default 7 days 
          if($request->has(['defaultDay'])){

            $startDay   = Carbon::today()->subDays(7)->format('Y-m-d');

            $endDay     = Carbon::today()->format('Y-m-d');

            $arrayDay = $this->initDays($startDay,$endDay);

            $report = $this->orderRepository->reportSaleDaily($input,$arrayDay);

            return $this->responseSuccess('Data success',$report);
       
        } else 
          // report default 12 month
          if($request->has(['defaultMonth'])){

            $startMonth  = Carbon::today()->subMonth(12)->format('Y-m-d');

            $endMonth    = Carbon::today()->format('Y-m-d');

            $arrayMonth = $this->initInMonth($startMonth,$endMonth);

            $report = $this->orderRepository->reportSaleMonth($input,$arrayMonth);

            return $this->responseSuccess('Data success',$report);

          }  else 

          if($request->has(['defaultYear'])){

            $startYear  = Carbon::today()->subYears(2)->format('Y-m');

            $endYear    = Carbon::today()->format('Y-m');

            $arrayYear = $this->initYear($startYear,$endYear);

            $report = $this->orderRepository->reportSaleYear($input,$arrayYear);

            return $this->responseSuccess('Data success',$report);

          }

        else
        {

          return $this->responseError('Failed!', [
                'error' => 'Data not found',
            ],500);
        }
    }
}
