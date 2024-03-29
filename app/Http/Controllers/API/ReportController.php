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


	  public function totalIncomeReport(Request $request){

		    $input = $request->all();

        // report from day, to day
       	if($request->has(['start_day','end_day'])){

       		$arrayDay = $this->initDays($input['start_day'],$input['end_day']);

       		$report = $this->transactionRepository->transactionDailyReport($input,$arrayDay);

       		return $this->responseSuccess('Data success',$report);

       	} else if($request->has(['start_month','end_month'])){
        // report from month, to month

         		$arrayInMonth = $this->initInMonth($input['start_month'],$input['end_month']);

         		$report = $this->transactionRepository->transactionMonthlyReport($input,$arrayInMonth);

         		return $this->responseSuccess('Data success',$report);

       	} else if($request->has(['start_year','end_year'])){
        // report year

         		$arrayMonthInYear = $this->initYear($input['start_year'],$input['end_year']);

         		$report = $this->transactionRepository->transactionYearlyReport($input,$arrayMonthInYear);

         		return $this->responseSuccess('Data success',$report);

       	} else if($request->has(['start_day_week','end_day_week'])){
        // report week

            $arrayWeek = $this->initDayWeekDays($input['start_day_week'],$input['end_day_week']);

            $report = $this->transactionRepository->transactionWeeklyReport($input,$arrayWeek);

            return $this->responseSuccess('Data success',$report);

        } else if ($request->has(['defaultWeek'])) {
        // report default week

         		$arrayWeek = $this->initWeekDays();

         		$report = $this->transactionRepository->transactionWeeklyReport($input,$arrayWeek);

         		return $this->responseSuccess('Data success',$report);

       	} else if($request->has(['defaultDay'])){
        // report default 7 days

            $startDay   = Carbon::today()->subDays(7)->format('Y-m-d');

            $endDay     = Carbon::today()->format('Y-m-d');

            $arrayDay = $this->initDays($startDay,$endDay);

            $report = $this->transactionRepository->transactionDailyReport($input,$arrayDay);

            return $this->responseSuccess('Data success',$report);

        } else if($request->has(['defaultMonth'])){
        // report default 12 month

            $startMonth  = Carbon::today()->subMonth(12)->format('Y-m-d');

            $endMonth    = Carbon::today()->format('Y-m-d');

            $arrayMonth = $this->initInMonth($startMonth,$endMonth);

            $report = $this->transactionRepository->transactionMonthlyReport($input,$arrayMonth);

            return $this->responseSuccess('Data success',$report);

        } else if($request->has(['defaultYear'])){

            $startYear  = Carbon::today()->subYears(2)->format('Y-m');

            $endYear    = Carbon::today()->format('Y-m');

            $arrayYear = $this->initYear($startYear,$endYear);

            $report = $this->transactionRepository->transactionYearlyReport($input,$arrayYear);

            return $this->responseSuccess('Data success',$report);

        } else {

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
        while($date <=$end_year){
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
        if(isset($input['type'])){
            $type = $input['type'];
            if($type == 'day'){
                $arrayDay = [];
                if(isset($input['start_day']) && !isset($input['end_day'])){
                    $temp = Carbon::parse($input['start_day']);
                    $endDay = $temp->addDays(7);
                    $now =  Carbon::today();
                    if($endDay > $now ){
                      $endDay = $now->format('m/d/Y');
                    }else{
                      $endDay = $endDay->format('m/d/Y');
                    }

                    $arrayDay = $this->initDays($input['start_day'], $endDay);
                }

                elseif(isset($input['end_day']) && !isset($input['start_day'])){
                    $temp = Carbon::parse($input['end_day']);
                    $startDay = $temp->subDays(7)->format('m/d/Y');
                    $arrayDay = $this->initDays($startDay, $input['end_day']);
                }
                elseif(isset($input['start_day']) && isset($input['end_day'])){
                  $arrayDay = $this->initDays($input['start_day'],$input['end_day']);
                }else{
                    $startDay   = Carbon::today()->subDays(7)->format('Y-m-d');

                    $endDay     = Carbon::today()->format('Y-m-d');

                    $arrayDay = $this->initDays($startDay,$endDay);
                }

                $report = $this->orderRepository->reportSaleDaily($input,$arrayDay);

                return $this->responseSuccess('Data success',$report);
          }

          if($type == 'month'){
                $arrayInMonth = [];
                if($input['start_month'] != 'Invalid date' && $input['end_month'] == 'Invalid date'){
                    $temp = Carbon::parse($input['start_month']);
                    $toMonth = $temp->addMonths(12);
                    $now =  Carbon::today();
                    if($toMonth > $now ){
                      $toMonth = $now->format('m/d/Y');
                    }else{
                      $toMonth = $toMonth->format('m/d/Y');
                    }

                    $arrayInMonth = $this->initInMonth($input['start_month'], $toMonth);
                }

                elseif($input['end_month'] != 'Invalid date' && $input['start_month'] == 'Invalid date'){
                    $temp = Carbon::parse($input['end_month']);
                    $fromMonth = $temp->subMonths(12)->format('Y-m-d');
                    $arrayInMonth = $this->initInMonth($fromMonth, $input['end_month']);
                }
                elseif($input['end_month'] != 'Invalid date' && $input['start_month'] != 'Invalid date'){
                    $arrayInMonth = $this->initInMonth($input['start_month'],$input['end_month']);

                }else{
                    $startMonth  = Carbon::today()->subMonth(12)->format('Y-m-d');

                    $endMonth    = Carbon::today()->format('Y-m-d');

                    $arrayInMonth = $this->initInMonth($startMonth,$endMonth);
                }


                $report = $this->orderRepository->reportSaleMonth($input,$arrayInMonth);

                return $this->responseSuccess('Data success',$report);
          }
          if($type == 'year'){
                $arrayMonthInYear = [];
                if($input['start_year'] != 'Invalid date' && $input['end_year'] == 'Invalid date'){
                    $temp = Carbon::parse($input['start_year']);
                    $to_year = $temp->addYears(2);
                    $now =  Carbon::today();
                    if($to_year > $now ){
                      $to_year = $now->format('Y-m');
                    }else{
                      $to_year = $to_year->format('Y-m');
                    }
                    $arrayMonthInYear = $this->initYear($input['start_year'], $to_year);

                }

                elseif($input['end_year'] != 'Invalid date' && $input['start_year'] == 'Invalid date'){
                    $temp = Carbon::parse($input['end_year']);
                    $from_year = $temp->subYears(2)->format('Y-m');
                    $arrayMonthInYear = $this->initYear($from_year, $input['end_year']);
                }
                elseif($input['start_year'] != 'Invalid date' && $input['end_year'] != 'Invalid date'){
                    $arrayMonthInYear = $this->initYear($input['start_year'],$input['end_year']);
                }else{
                    $startYear  = Carbon::today()->subYears(2)->format('Y-m');

                    $endYear    = Carbon::today()->format('Y-m');

                    $arrayMonthInYear = $this->initYear($startYear,$endYear);
                }

                $report = $this->orderRepository->reportSaleYear($input,$arrayMonthInYear);

                return $this->responseSuccess('Data success',$report);
          }
            if($type == 'week'){
                $arrayWeek = [];
                if(isset($input['start_day_week']) && !isset($input['end_day_week'])){

                    $temp = Carbon::parse($input['start_day_week'] );
                    $endDay = $temp->addDays(42);
                    $now =  Carbon::today();
                    if($endDay > $now ){
                      $endDay = $now->format('m/d/Y');
                    }else{
                      $endDay = $endDay->format('m/d/Y');
                    }
                    $arrayWeek = $this->initDayWeekDays($input['start_day_week'], $endDay);
                }

                elseif(isset($input['end_day_week']) && !isset($input['start_day_week'])){
                    $temp = Carbon::parse($input['end_day_week']);
                    $startDay = $temp->subDays(42)->format('m/d/Y');
                    $arrayWeek = $this->initDayWeekDays($startDay, $input['end_day_week']);
                }
                elseif(isset($input['start_day_week']) && isset($input['end_day_week'])){
                  $arrayWeek = $this->initDayWeekDays($input['start_day_week'],$input['end_day_week']);
                }else{
                    $startDay   = Carbon::today()->subDays(42)->format('Y-m-d');

                    $endDay     = Carbon::today()->format('Y-m-d');

                    $arrayWeek = $this->initDayWeekDays($startDay,$endDay);
                }

                $report = $this->orderRepository->reportSaleWeek($input,$arrayWeek);

                return $this->responseSuccess('Data success',$report);

            }
        }

        else
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
