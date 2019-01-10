<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Transaction;
use InfyOm\Generator\Common\BaseRepository;
use Carbon\Carbon;
use DB;



/**
 * Class OrderRepository
 * @package App\Repositories
 * @version January 9, 2019, 6:50 am UTC
 *
 * @method Order findWithoutFail($id, $columns = ['*'])
 * @method Order find($id, $columns = ['*'])
 * @method Order first($columns = ['*'])
*/
class OrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'branch_id',
        'photographer_id',
        'customer_id',
        'total_amount',
        'purchase_date',
        'download_date',
        'payment_method',
        'purchase_from',
        'status',
        'invoice'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Order::class;
    }

    public function reportSaleDaily($attributes,$dates){
       if(isset($attributes['start_day']) && isset($attributes['end_day']) )
        {
            $startDay = Carbon::parse($attributes['start_day'])->format('Y-m-d');

            $endDay = Carbon::parse($attributes['end_day'])->format('Y-m-d');

        }else {

            $startDay   = Carbon::today()->subDays(7)->format('Y-m-d');

            $endDay     = Carbon::today()->format('Y-m-d');
        }
    
        $company_id = 19;

        $orders = $this->scopeQuery(function($query) use ($company_id,$startDay,$endDay){
            $query = $query->with(['branch' => function($q){
                      }])
                      ->with(['customer.room' => function($q){
                      }])
                      ->with(['customer.user' => function($q){
                      }])
                      ->with(['photographer' => function($q){
                      }])
                      ->with('orderexchange')
                      ->whereHas('branch', function($q) use ($company_id) {
                        // $q->where('branches.company_id',$company_id);
                      })
                      ->where('status','DONE')
                      ->whereBetween(DB::raw('date(created_at)'),[$startDay,$endDay]);

            return $query;
         })->get()->toArray();

        
        $dates = $this->sumAmount($dates, $orders, 'day');
       
        return $dates;
    }

    public function reportSaleMonth($attributes,$InMonth){

        if(isset($attributes['start_month']) && isset($attributes['end_month']))
        {
            $fromMonth = Carbon::parse($attributes['start_month'])->format('Y-m');

            $toMonth = Carbon::parse($attributes['end_month'])->format('Y-m');
        }
        else {

            $fromMonth = Carbon::today()->subMonth(12)->format('Y-m');

            $toMonth = Carbon::today()->format('Y-m');
        }

        $company_id = 19;

        $orders = $this->scopeQuery(function($query) use ($company_id,$fromMonth,$toMonth){
            $query = $query->with(['branch' => function($q){
                      }])
                      ->with(['customer.room' => function($q){
                      }])
                      ->with(['customer.user' => function($q){
                      }])
                      ->with(['photographer' => function($q){
                      }])
                      ->with('orderexchange')
                      ->whereHas('branch', function($q) use ($company_id) {
                        // $q->where('branches.company_id',$company_id);
                      })
                      ->where('status','DONE')
                      ->where(DB::raw("DATE_FORMAT(created_at,'%Y-%m')"), '>=', $fromMonth)
                        ->where(DB::raw("DATE_FORMAT(created_at,'%Y-%m')"), '<=', $toMonth);

            return $query;
         })->get()->toArray();

        $InMonth = $this->sumAmount($InMonth, $orders, 'month');

        return $InMonth;
    }

    public function reportSaleYear($attributes,$InYear){

        if(isset($attributes['start_year']) && isset($attributes['end_year']))
        {
            $from_year = Carbon::parse($attributes['start_year'])->format('Y');

            $to_year = Carbon::parse($attributes['end_year'])->format('Y');
        }
        else {

            $from_year = Carbon::today()->subYears(2)->format('Y-m');

            $to_year = Carbon::today()->format('Y-m');
        }

        $company_id = 19;

        $orders = $this->scopeQuery(function($query) use ($company_id,$from_year,$to_year){
            $query = $query->with(['branch' => function($q){
                      }])
                      ->with(['customer.room' => function($q){
                      }])
                      ->with(['customer.user' => function($q){
                      }])
                      ->with(['photographer' => function($q){
                      }])
                      ->with('orderexchange')
                      ->whereHas('branch', function($q) use ($company_id) {
                        // $q->where('branches.company_id',$company_id);
                      })
                      ->where('status','DONE')
                      ->where(DB::raw("DATE_FORMAT(created_at,'%Y')"), '>=', $from_year)
                        ->where(DB::raw("DATE_FORMAT(created_at,'%Y')"), '<=', $to_year);

            return $query;
         })->get()->toArray();

        $InYear = $this->sumAmount($InYear, $orders, 'year');
 

        return $InYear;
    }

    public function reportSaleWeek($attributes,$dayWeek){

        if(isset($attributes['start_day_week']) && isset($attributes['end_day_week']))
        {
            $startDay = Carbon::parse($attributes['start_day_week'])->format('Y-m-d');

            $endDay = Carbon::parse($attributes['end_day_week'])->format('Y-m-d');
        }
        else {

            $startDay   = Carbon::today()->subDays(42)->format('Y-m-d');

            $endDay     = Carbon::today()->format('Y-m-d');

        }          


        $company_id = 19;

        $orders = $this->scopeQuery(function($query) use ($company_id,$startDay,$endDay){
            $query = $query->with(['branch' => function($q){
                      }])
                      ->with(['customer.room' => function($q){
                      }])
                      ->with(['customer.user' => function($q){
                      }])
                      ->with(['photographer' => function($q){
                      }])
                      ->with('orderexchange')
                      ->whereHas('branch', function($q) use ($company_id) {
                        // $q->where('branches.company_id',$company_id);
                      })
                      ->where('status','DONE')
                      ->whereBetween(DB::raw('date(created_at)'),[$startDay,$endDay]);

            return $query;
        })->get()->toArray();                                       

        foreach ($dayWeek as $key => $date) {

            $count=0;
            if(count($orders)) {
                foreach ($orders as $k_v => $value) {
                    
                    $day = Carbon::parse($value['created_at'])->format('Y-m-d');

                    if($date['startOfWeek'] <= $day && $day <= $date['endOfWeek']) {

                        $total_amount = $value['total_amount'];

                        $exchange_rate_to_dollar =  $value['orderexchange']['exchange_rate_to_dollar'];

                        $count = $count + $total_amount *  $exchange_rate_to_dollar;  
                    } 
                    else {
                        $dayWeek[$key]['total'] = 0;
                       
                    }
                }

                $dayWeek[$key]['total'] = round($count,3);
            }  else {
                $dayWeek[$key]['total'] = 0;
            }   
       
        }    
    

        return $dayWeek;    
    
    }

    public function sumAmount($dates, $orders, $timevalue){
        foreach ($dates as $key => $date) {
            $count=0;
            if(count($orders)){
                foreach ($orders as $k_v => $value) {

                        if($timevalue == 'day'){

                            $time_value = Carbon::parse($value['created_at'])->format('Y-m-d');
                        }
                        if($timevalue == 'month'){
                            $time_value = Carbon::parse($value['created_at'])->format('Y-m');
                        }
                        if($timevalue == 'year'){
                            $time_value = Carbon::parse($value['created_at'])->format('Y');
                        }                    
                    
                    if($key == $time_value) {

                        $total_amount = $value['total_amount'];

                        $exchange_rate_to_dollar =  $value['orderexchange']['exchange_rate_to_dollar'];


                        $count = $count + $total_amount *  $exchange_rate_to_dollar;
                                     

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
