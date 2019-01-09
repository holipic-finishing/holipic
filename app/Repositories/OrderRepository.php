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
       
        $transactions = Transaction::with('transactionexchange')
                        ->where('status','RECIVED')
                        ->whereBetween(DB::raw('date(dated)'),[$startDay,$endDay])
                        ->get()->toArray();


        $dates = $this->sumAmount($dates, $transactions, 'day');
       
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

        $transactions = Transaction::with('transactionexchange')
                        ->where('status','RECIVED')
                        ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '>=', $fromMonth)
                        ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '<=', $toMonth)
                        ->get()->toArray();


        $InMonth = $this->sumAmount($InMonth, $transactions, 'month');

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


        $transactions = Transaction::with('transactionexchange')
                        ->where('status','RECIVED')
                        ->where(DB::raw("DATE_FORMAT(dated,'%Y')"), '>=', $from_year)
                        ->where(DB::raw("DATE_FORMAT(dated,'%Y')"), '<=', $to_year)
                        ->get()->toArray();

        $InYear = $this->sumAmount($InYear, $transactions, 'year');
 

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

        $transactions = Transaction::with('transactionexchange')
                        ->where('status','RECIVED')
                        ->whereBetween(DB::raw('date(dated)'),[$startDay,$endDay])
                        ->get()->toArray();                       


        foreach ($dayWeek as $key => $date) {

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

                $dayWeek[$key]['total'] = round($count,3);
            }  else {
                $dayWeek[$key]['total'] = 0;
            }      
        }    
    

        return $dayWeek;
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
