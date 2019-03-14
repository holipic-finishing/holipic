<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Package;
use InfyOm\Generator\Common\BaseRepository;
use DB;
use Carbon\Carbon;

/**
 * Class TransactionRepository
 * @package App\Repositories
 * @version December 10, 2018, 4:42 am UTC
 *
 * @method Transaction findWithoutFail($id, $columns = ['*'])
 * @method Transaction find($id, $columns = ['*'])
 * @method Transaction first($columns = ['*'])
*/
class TransactionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'amount',
        'status',
        'company_id',
        'dated'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Transaction::class;
    }

    /********* Transaction Report: Daily, Monthly, Yearly, Weekly ***********/

    public function transactionDailyReport($attributes, $dates){

        if(isset($attributes['start_day']) && isset($attributes['end_day']) )
        {
            $startDay = Carbon::parse($attributes['start_day'])->format('Y-m-d');

            $endDay = Carbon::parse($attributes['end_day'])->format('Y-m-d');

        }else {

            $startDay   = Carbon::today()->subDays(7)->format('Y-m-d');

            $endDay     = Carbon::today()->format('Y-m-d');
        }
       

        $transactions = Transaction::with('transactionexchange')
                        ->where('status','RECIVED')
                        ->whereBetween(DB::raw('date(dated)'),[$startDay,$endDay])
                        ->get()->toArray();


        $dates = $this->sumAmount($dates, $transactions, 'day');
       
        return $dates;
    }

    public function transactionMonthlyReport($attributes,$months){

        if(isset($attributes['start_month']) && isset($attributes['end_month']))
        {
            $fromMonth = Carbon::parse($attributes['start_month'])->format('Y-m');

            $toMonth = Carbon::parse($attributes['end_month'])->format('Y-m');
        }
        else {

            $fromMonth = Carbon::today()->subMonth(12)->format('Y-m');

            $toMonth = Carbon::today()->format('Y-m');
        }

        $transactions = Transaction::with('transactionexchange')
                        ->where('status','RECIVED')
                        ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '>=', $fromMonth)
                        ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '<=', $toMonth)
                        ->get()->toArray();


        $months = $this->sumAmount($months, $transactions, 'month');

        return $months;
    }

    public function transactionYearlyReport($attributes, $years){

        if(isset($attributes['start_year']) && isset($attributes['end_year']))
        {
            $from_year = Carbon::parse($attributes['start_year'])->format('Y');

            $to_year = Carbon::parse($attributes['end_year'])->format('Y');
        }
        else {

            $from_year = Carbon::today()->subYears(2)->format('Y-m');

            $to_year = Carbon::today()->format('Y-m');
        }


        $transactions = Transaction::with('transactionexchange')
                        ->where('status','RECIVED')
                        ->where(DB::raw("DATE_FORMAT(dated,'%Y')"), '>=', $from_year)
                        ->where(DB::raw("DATE_FORMAT(dated,'%Y')"), '<=', $to_year)
                        ->get()->toArray();

        $years = $this->sumAmount($years, $transactions, 'year');
 

        return $years;

    }

    public function transactionWeeklyReport($attributes, $dayWeeks){


        if(isset($attributes['start_day_week']) && isset($attributes['end_day_week']))
        {
            $startDay = Carbon::parse($attributes['start_day_week'])->format('Y-m-d');

            $endDay = Carbon::parse($attributes['end_day_week'])->format('Y-m-d');
        }
        else {

            $startDay   = Carbon::today()->subDays(42)->format('Y-m-d');

            $endDay     = Carbon::today()->format('Y-m-d');

        }          

        $transactions = Transaction::with('transactionexchange')
                        ->where('status','RECIVED')
                        ->whereBetween(DB::raw('date(dated)'),[$startDay,$endDay])
                        ->get()->toArray();                       


        foreach ($dayWeeks as $key => $date) {

            $count=0;
            if(count($transactions)) {
                foreach ($transactions as $k_v => $value) {
                    
                    $day = Carbon::parse($value['dated'])->format('Y-m-d');

                    if($date['startOfWeek'] <= $day && $day <= $date['endOfWeek']) {

                        $amount = $value['amount'];

                        $exchange_rate_to_dollar =  $value['transactionexchange']['exchange_rate_to_dollar'];

                        $count = $count + $amount *  $exchange_rate_to_dollar;  
                    } 
                    else {
                        $dayWeek[$key]['total'] = 0;
                       
                    }
                }

                $dayWeeks[$key]['total'] = round($count,3);
            }  else {
                $dayWeeks[$key]['total'] = 0;
            }   
       
        }    
    

        return $dayWeeks;
    }

    /******************** End Transaction Report  **********************/

    /**
     * get Histories Transaction
     */
    public function getHistoriesTransaction($params){
        $results = $this->scopeQuery(function($query) use($params){

            // $query = $query->with(['user' => function($q) {
            //                     $q->with('package')->with(['company' => function($que) {
            //                         $que->withTrashed();
            //                     }]);
            //                 }]);
            $query = $query->with(['company' => function($q) {
                                $q->withTrashed();
                            }]);

            $query = $query->with('currency')
                        ->with('transactionexchange');
          
            if (!empty($params['defaultDay'])) {

                $startDay   = Carbon::today()->subDays(7)->format('Y-m-d');
                $endDay     = Carbon::today()->format('Y-m-d');

                $query = $query->whereBetween(DB::raw('date(dated)'), [$startDay,$endDay]);
            }

            if(!empty($params['start_day']) && !empty($params['end_day']) ){

                $startDay = Carbon::parse($params['start_day'])->format('Y-m-d');
                $endDay = Carbon::parse($params['end_day'])->format('Y-m-d');

                $query = $query->whereBetween(DB::raw('date(dated)'), [$startDay,$endDay]);
            }

            if (!empty($params['defaultWeek'])) {

                $startDay = Carbon::today()->subDays(42)->format('Y-m-d');
                $endDay = Carbon::today()->format('Y-m-d');

                $query = $query->whereBetween(DB::raw('date(dated)'), [$startDay,$endDay]);
            }

            if(!empty($params['start_day_week']) && !empty($params['end_day_week']) ){

                $startDay = Carbon::parse($params['start_day_week'])->format('Y-m-d');
                $endDay = Carbon::parse($params['end_day_week'])->format('Y-m-d');

                $query = $query->whereBetween(DB::raw('date(dated)'), [$startDay,$endDay]);
            }

            if (!empty($params['defaultMonth'])) {

                $fromMonth = Carbon::today()->subMonth(12)->format('Y-m');
                $toMonth = Carbon::today()->format('Y-m');

                $query = $query->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '>=', $fromMonth)
                                ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '<=', $toMonth);
            }

            if(!empty($params['start_month']) && !empty($params['end_month'])){

                $fromMonth = Carbon::parse($params['start_month'])->format('Y-m');
                $toMonth = Carbon::parse($params['end_month'])->format('Y-m');

                $query = $query->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '>=', $fromMonth)
                                ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '<=', $toMonth);
            }

            if (!empty($params['defaultYear'])) {

                $from_year = Carbon::today()->subYears(2)->format('Y-m');
                $to_year = Carbon::today()->format('Y-m');

                $query = $query->where(DB::raw("DATE_FORMAT(dated,'%Y')"), '>=', $from_year)
                                ->where(DB::raw("DATE_FORMAT(dated,'%Y')"), '<=', $to_year);
            }

            if(!empty($params['start_year']) && !empty($params['end_year']) ){

                $from_year = Carbon::parse($params['start_year'])->format('Y');
                $to_year = Carbon::parse($params['end_year'])->format('Y');

                $query = $query->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '>=', $from_year)
                                ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '<=', $to_year);
            }

            return $query;
        })->get();
        $results = $this->transform($results);

        return $results; 
    }  

    /**
     * Transfrom transaction data
     */
    public function transform($results){

        foreach ($results as $key => $result) {

            $results[$key]->company_name = $result->company->name;

            $results[$key]->amount_with_symbol = round(($result->amount * $result->transactionexchange->exchange_rate_to_dollar),3)." ".$result->symbol; 

            $results[$key]->system_fee_with_symbol = round(($result->system_fee * $result->transactionexchange->exchange_rate_to_dollar),3)." ".$result->symbol;         
            $results[$key]->credit_card_fee_with_symbol = round(($result->credit_card_fee * $result->transactionexchange->exchange_rate_to_dollar),3) ." ".$result->symbol;

            // $results[$key]->fullname = $result->user->first_name . " " . $result->user->last_name;
        }

        return $results;
    } 


    /*
    *  Target  : Function get all data in table transactions history by Day and, user_id
    *  @params : array $attribute, int $perPage, array $serchBy
    *  @return : Collection
    */
    public function transactionHistoryDay($attributes,$perPage,$searchBy) {

        $now     = \Carbon\Carbon::today()->format('Y-m-d');
        $user_id = $attributes['userId'];
        $search = '';

        if (!empty($searchBy['title'])) {
            $search = $searchBy['title'];
        }

        $transactions = $this->scopeQuery(function($query) use($search, $user_id, $now){

            $query = $query->select('id','title','dated','amount','status')
                                ->with(['transactionexchange' => function($query){
                                    $query->select(['exchange_rate_to_dollar','transaction_id']);
                                }])
                                ->whereHas('companyUser', function($query) use ($user_id){
                                    $query->where('owner_id',$user_id);
                                });

            if (!empty($search)) {
                $query = $query->where(function($query) use ($search){
                                    $query->where('title','LIKE', '%'. $search . '%')
                                        ->orWhere('dated','LIKE', '%'. $search . '%');
                                });
            }


            $query = $query->where(DB::raw('date(dated)'),$now)
                                    ->orderBy('dated', 'desc');

            return $query;

        });

        return $transactions->paginate($perPage);                            

    }

    /*
    *  Target  : Function get all data in table transactions history by week and, user_id
    *  @params : array $attribute, int $perPage, array $serchBy
    *  @return : Collection
    */
    public function transactionHistoryWeek($attributes,$perPage ,$searchBy) {

        $startDay   = \Carbon\Carbon::today()->subDays(7)->format('Y-m-d');
        $endDay     = \Carbon\Carbon::today()->format('Y-m-d');
        $user_id = $attributes['userId'];
        
        $search = '';

        if (!empty($searchBy['title'])) {
            $search = $searchBy['title'];
        }

        $transactions = $this->scopeQuery(function($query) use($search, $user_id, $startDay, $endDay){

            $query = $query->select('id','title','dated','amount','status')
                                ->with(['transactionexchange' => function($query){
                                    $query->select(['exchange_rate_to_dollar','transaction_id']);
                                }])
                                ->whereHas('companyUser', function($query) use ($user_id){
                                    $query->where('owner_id',$user_id);
                                });

            if (!empty($search)) {

                $query = $query->where(function($query) use ($search){
                                        $query->where('title','LIKE', '%'. $search . '%')
                                            ->orWhere('dated','LIKE', '%'. $search . '%');
                                    });
            }


            $query = $query->whereBetween(DB::raw('date(dated)'),[$startDay,$endDay])
                                    ->orderBy('dated', 'desc');

            return $query;

        });
        
        return $transactions->paginate($perPage);                            

    }

    /*
    *  Target  : Function get all data in table transactions history by Month and, user_id
    *  @params : array $attribute, int $perPage, array $serchBy
    *  @return : Collection
    */
    public function transactionHistoryMonth($attributes,$perPage, $searchBy) {

        $month = \Carbon\Carbon::today()->format('Y-m');
        $user_id = $attributes['userId'];
        
        $search = '';

        if (!empty($searchBy['title'])) {
            $search = $searchBy['title'];
        }
      
        $transactions = $this->scopeQuery(function($query) use($search, $user_id, $month){

            $query = $query->select('id','title','dated','amount','status')
                            ->with(['transactionexchange' => function($query){
                                $query->select(['exchange_rate_to_dollar','transaction_id']);
                            }])
                            ->whereHas('companyUser', function($query) use ($user_id){
                                $query->where('owner_id',$user_id);
                            });
            
            if(!empty($search)){

                $query = $query->where(function($query) use ($search){
                                    $query->where('title','LIKE', '%'. $search . '%')
                                        ->orWhere('dated','LIKE', '%'. $search . '%');
                                });
            }


            $query = $query->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), $month)
                                    ->orderBy('dated', 'desc');

            return $query;

        });

        return $transactions->paginate($perPage); 

    }

    /*
    *  Target  : Function get all data in table transactions history by Year and, user_id
    *  @params : array $attribute, int $perPage, array $serchBy
    *  @return : Collection
    */
    public function transactionHistoryYear($attributes,$perPage, $searchBy) {

        $year = \Carbon\Carbon::today()->format('Y');
        $user_id = $attributes['userId'];
        
        $search = '';

        if (!empty($searchBy['title'])) {
            $search = $searchBy['title'];
        }

        $transactions = $this->scopeQuery(function($query) use($search, $user_id, $year){

            $query = $query->select('id','title','dated','amount','status')
                                ->with(['transactionexchange' => function($query){
                                    $query->select(['exchange_rate_to_dollar','transaction_id']);
                                }])
                                ->whereHas('companyUser', function($query) use ($user_id){
                                    $query->where('owner_id',$user_id);
                                });

            if (!empty($search)) {
                $query = $query->where(function($query) use ($search){
                                    $query->where('title','LIKE', '%'. $search . '%')
                                        ->orWhere('dated','LIKE', '%'. $search . '%');
                                });
            }


            $query = $query->where(DB::raw("DATE_FORMAT(dated,'%Y')"), $year)
                                    ->orderBy('dated', 'desc');

            return $query;

        });

        return $transactions->paginate($perPage); 

    }
    
    /*
    *  Target : Get all data in transaction history in array with key by "Day", "Week", "Month", "Year"
    *  From   : func: transactionHistoryDay, func:transactionHistoryWeek, func:transactionHistoryMonth,       func:transactionHistoryYear
    *  To : array $attributes, int $prerPage, array $searchBy
    */ 
    public function transactionHistory($attributes, $perPage, $searchBy){

        switch ($attributes['time']) {
            case 'Day':
                $result = $this->transactionHistoryDay($attributes,$perPage, $searchBy);
                return $result;
                break;

            case 'Week':
                $result = $this->transactionHistoryWeek($attributes,$perPage, $searchBy);
                return $result;
                break;

            case 'Month':
                $result = $this->transactionHistoryMonth($attributes,$perPage, $searchBy);
                return $result;
                break;

            case 'Year':
                $result = $this->transactionHistoryYear($attributes,$perPage, $searchBy);
                return $result;
                break;
            
            default:
                # code...
                break;
        }
    }

    public function checkValueTime($request)
    {
        if($request['toTime'] != null && $request['toTime'] != null) {

        }
    }

    public function sumAmount($dates, $transactions, $timevalue){

        foreach ($dates as $key => $date) {
            $count=0;
            if(count($transactions)){
                foreach ($transactions as $k_v => $value) {

                        if($timevalue == 'day'){

                            $time_value = Carbon::parse($value['dated'])->format('Y-m-d');
                        }
                        if($timevalue == 'month'){
                            $time_value = Carbon::parse($value['dated'])->format('Y-m');
                        }
                        if($timevalue == 'year'){
                            $time_value = Carbon::parse($value['dated'])->format('Y');
                        }                    
                    
                    if($key == $time_value) {

                        $amount = $value['amount'];

                        $exchange_rate_to_dollar =  $value['transactionexchange']['exchange_rate_to_dollar'];

                        $count = $count + $amount *  $exchange_rate_to_dollar;
                                     

                    } else {
                        $dates[$key]['total'] = 0;
                    }
                }  
                 $dates[$key]['total'] = round($count,3);
                    
            } else {
                 $dates[$key]['total'] = 0;
            }           
        }
        return $dates;
    }
}
