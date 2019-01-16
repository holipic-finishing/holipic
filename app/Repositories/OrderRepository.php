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
        $startDay   = Carbon::today()->subDays(7)->format('Y-m-d');

        $endDay     = Carbon::today()->format('Y-m-d');

        $branch_id = "";

        $photographer_id = "";

        $company_id = $attributes['company_id'];

        if(isset($attributes['start_day'])){
            $temp = Carbon::parse($attributes['start_day']);
            $startDay = Carbon::parse($attributes['start_day'])->format('Y-m-d');
            $endDay = $temp->addDays(7)->format('Y-m-d');
        } 
        if(isset($attributes['end_day'])){
            $temp = Carbon::parse($attributes['end_day']);
            $endDay = Carbon::parse($attributes['end_day'])->format('Y-m-d');
            $startDay = $temp->subDays(7)->format('Y-m-d');

        }
      
        if(isset($attributes['start_day']) && isset($attributes['end_day'])){
            $startDay = Carbon::parse($attributes['start_day'])->format('Y-m-d');
            $endDay = Carbon::parse($attributes['end_day'])->format('Y-m-d');
        }
        if(isset($attributes['branch_id'])){
          $branch_id = $attributes['branch_id'];
        }

        if(isset($attributes['photographer_id'])){
          $photographer_id = $attributes['photographer_id'];
        }
        $orders = $this->scopeQuery(function($query) use ($startDay,$endDay, $company_id, $branch_id, $photographer_id){
            $query = $query->with(['branch' => function($q){
                      }])
                      ->with(['customer.room' => function($q){
                      }])
                      ->with(['customer.user' => function($q){
                      }])
                      ->with(['photographer' => function($q){
                      }])
                      ->with('orderexchange')
                      ->whereHas('branch', function($q) use($company_id){
                        $q->where('branches.company_id',$company_id);
                      })
                      ->where('status','DONE')
                      ->whereBetween(DB::raw('date(created_at)'),[$startDay,$endDay]);
            if($branch_id != ''){
              $query = $query->where('branch_id', $branch_id);
            }
            if($photographer_id != ''){
              $query = $query->where('photographer_id', $photographer_id);
            }

            return $query;
         })->get()->toArray();

        $dates = $this->sumAmount($dates, $orders, 'day');
        return $dates;
    }

    public function reportSaleMonth($attributes,$InMonth){

        $fromMonth = Carbon::today()->subMonth(12)->format('Y-m');

        $toMonth = Carbon::today()->format('Y-m');

        $branch_id = "";

        $photographer_id = "";


        $company_id = $attributes['company_id'];

        if(isset($attributes['start_month']) && $attributes['start_month']  != 'Invalid date'){
            $temp = Carbon::parse($attributes['start_month']);
            $fromMonth = Carbon::parse($attributes['start_month'])->format('Y-m');
            $toMonth = $temp->addMonths(12)->format('Y-m');
        }
        if(isset($attributes['end_month']) && $attributes['end_month']  != 'Invalid date'){
            $temp = Carbon::parse($attributes['end_month']);
            $toMonth = Carbon::parse($attributes['end_month'])->format('Y-m');
            $fromMonth = $temp->subMonths(12)->format('Y-m');
        }

        if(isset($attributes['start_month']) && $attributes['start_month']  != 'Invalid date' && isset($attributes['end_month']) && $attributes['end_month']  != 'Invalid date'){
             $fromMonth = Carbon::parse($attributes['start_month'])->format('Y-m');

            $toMonth = Carbon::parse($attributes['end_month'])->format('Y-m');
        }


        if(isset($attributes['branch_id'])){
          $branch_id = $attributes['branch_id'];
        }

        if(isset($attributes['photographer_id'])){
          $photographer_id = $attributes['photographer_id'];
        }

        $orders = $this->scopeQuery(function($query) use ($fromMonth,$toMonth,$company_id,$branch_id, $photographer_id){
            $query = $query->with(['branch' => function($q){
                      }])
                      ->with(['customer.room' => function($q){
                      }])
                      ->with(['customer.user' => function($q){
                      }])
                      ->with(['photographer' => function($q){
                      }])
                      ->with('orderexchange')
                      ->whereHas('branch', function($q) use($company_id){
                        $q->where('branches.company_id',$company_id);
                      })
                      ->where('status','DONE')
                      ->where(DB::raw("DATE_FORMAT(created_at,'%Y-%m')"), '>=', $fromMonth)
                      ->where(DB::raw("DATE_FORMAT(created_at,'%Y-%m')"), '<=', $toMonth);
            if($branch_id != ''){
              $query = $query->where('branch_id', $branch_id);
            }
            if($photographer_id != ''){
              $query = $query->where('photographer_id', $photographer_id);
            }
            return $query;
         })->get()->toArray();

        $InMonth = $this->sumAmount($InMonth, $orders, 'month');

        return $InMonth;
    }

    public function reportSaleYear($attributes,$InYear){

        $from_year = Carbon::today()->subYears(2)->format('Y');

        $to_year = Carbon::today()->format('Y');

        $branch_id = "";

        $photographer_id = "";

        $company_id = $attributes['company_id'];

        if(isset($attributes['start_year']) && $attributes['start_year']  != 'Invalid date'){
            $temp = Carbon::parse($attributes['start_year']);
            $from_year = Carbon::parse($attributes['start_year'])->format('Y');
            $toMonth = $temp->addYears(2)->format('Y');
        }
        if(isset($attributes['end_year']) && $attributes['end_year']  != 'Invalid date'){
            $temp = Carbon::parse($attributes['end_year']);
            $toMonth = Carbon::parse($attributes['end_year'])->format('Y');
            $from_year = $temp->subYears(2)->format('Y');
        }

        if(isset($attributes['start_year']) && $attributes['start_year']  != 'Invalid date' && isset($attributes['end_year']) && $attributes['end_year']  != 'Invalid date'){
            $fromMonth = Carbon::parse($attributes['start_year'])->format('Y');

            $toMonth = Carbon::parse($attributes['end_year'])->format('Y');
        }


        if(isset($attributes['branch_id'])){
          $branch_id = $attributes['branch_id'];
        }

        if(isset($attributes['photographer_id'])){
          $photographer_id = $attributes['photographer_id'];
        }

        $orders = $this->scopeQuery(function($query) use ($from_year,$to_year, $company_id, $branch_id, $photographer_id){
            $query = $query->with(['branch' => function($q){
                      }])
                      ->with(['customer.room' => function($q){
                      }])
                      ->with(['customer.user' => function($q){
                      }])
                      ->with(['photographer' => function($q){
                      }])
                      ->with('orderexchange')
                      ->whereHas('branch', function($q) use($company_id) {
                        $q->where('branches.company_id',$company_id);
                      })
                      ->where('status','DONE')
                      ->where(DB::raw("DATE_FORMAT(created_at,'%Y')"), '>=', $from_year)
                        ->where(DB::raw("DATE_FORMAT(created_at,'%Y')"), '<=', $to_year);
            if($branch_id != ''){
              $query = $query->where('branch_id', $branch_id);
            }
            if($photographer_id != ''){
              $query = $query->where('photographer_id', $photographer_id);
            }
            return $query;
        })->get()->toArray();

        $InYear = $this->sumAmount($InYear, $orders, 'year');
 

        return $InYear;
    }

    public function reportSaleWeek($attributes,$dayWeek){

        $startDay   = Carbon::today()->subDays(42)->format('Y-m-d');

        $endDay     = Carbon::today()->format('Y-m-d');

        $branch_id = "";

        $photographer_id = "";

        $company_id = $attributes['company_id'];

        if(isset($attributes['start_day'])){
            $temp = Carbon::parse($attributes['start_day']);
            $startDay = Carbon::parse($attributes['start_day'])->format('Y-m-d');
            $endDay = $temp->addDays(42)->format('Y-m-d');
        } 
        if(isset($attributes['end_day'])){
            $temp = Carbon::parse($attributes['end_day']);
            $endDay = Carbon::parse($attributes['end_day'])->format('Y-m-d');
            $startDay = $temp->subDays(42)->format('Y-m-d');

        }
      
        if(isset($attributes['start_day']) && isset($attributes['end_day'])){
            $startDay = Carbon::parse($attributes['start_day'])->format('Y-m-d');
            $endDay = Carbon::parse($attributes['end_day'])->format('Y-m-d');
        }
        if(isset($attributes['branch_id'])){
          $branch_id = $attributes['branch_id'];
        }

        if(isset($attributes['photographer_id'])){
          $photographer_id = $attributes['photographer_id'];
        }
              
        $orders = $this->scopeQuery(function($query) use ($startDay,$endDay, $company_id,$branch_id,$photographer_id){
            $query = $query->with(['branch' => function($q){
                      }])
                      ->with(['customer.room' => function($q){
                      }])
                      ->with(['customer.user' => function($q){
                      }])
                      ->with(['photographer' => function($q){
                      }])
                      ->with('orderexchange')
                      ->whereHas('branch', function($q) use ($company_id){
                        $q->where('branches.company_id',$company_id);
                      })
                      ->where('status','DONE')
                      ->whereBetween(DB::raw('date(created_at)'),[$startDay,$endDay]);

            if($branch_id != ''){
              $query = $query->where('branch_id', $branch_id);
            }
            if($photographer_id != ''){
              $query = $query->where('photographer_id', $photographer_id);
            }

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
    
    // ********* Get all orders with branch, customer, photographer **********
    public function getAllOrders($company_id,$searchBy){
       
        $results = $this->scopeQuery(function($query) use ($searchBy,$company_id){
            $query = $query->whereHas('branch', function($q) use ($company_id) {
                        $q->where('branches.company_id',$company_id);
                      })
                      ->with(['branch' => function($q){
                        $q->select('name','id','company_id');
                      }])
                      ->with(['customer.room' => function($q){
                        $q->select('room_hash','id');
                      }])
                      ->with(['customer.user' => function($q){
                        $q->select('email','id');
                      }])
                      ->with(['photographer' => function($q){
                        $q->select('id','name');
                      }]);

            if (!empty($searchBy['branch_id'])) {
                if($searchBy['branch_id'] !== '0'){
                    $query = $query->where('branch_id',$searchBy['branch_id']);
                }
            }  

            if (!empty($searchBy['photographer_id'])) {
                if($searchBy['photographer_id'] !== '0'){

                $query = $query->where('photographer_id',$searchBy['photographer_id']);
                    
                }
            }  

            if (!empty($searchBy['from_day']) && !empty($searchBy['to_day'])) {

                $query = $query->where(DB::raw('date(purchase_date)'),'>=',$searchBy['from_day'])
                               ->where(DB::raw('date(purchase_date)'),'<=',$searchBy['to_day']);

            }   else if(!empty($searchBy['to_day'])){

                 $query = $query->where(DB::raw('date(purchase_date)'),$searchBy['to_day']);

            } else if(!empty($searchBy['from_day'])){

                 $query = $query->where(DB::raw('date(purchase_date)'),$searchBy['from_day']);
            }
        

          
            $query = $query->where('status','DONE');
             return $query;
         })->get();
      
        $results = $this->transform($results);
        // $this->insertCSVFile($results,$company_id);
        return $results;

    }

    //*********** Transfrom Orders data **************
    public function transform($results){

        foreach ($results as $key => $result) {
            $results[$key]->branch_name = $result->branch->name;
            $results[$key]->room_has_number = $result->customer->room->room_hash;
            $results[$key]->customer_email = $result->customer->user->email;
            $results[$key]->photographer_name = $result->photographer->name;
        }
        
        return $results;
    }

    //********** Insert File CSV **************
   public function insertCSVFile($attributes,$company_id){
 
        if(!$attributes)
            return false;

        $pathPublic = env('DB_MYSQL_DIR').DIRECTORY_SEPARATOR;

        $filename =  $company_id . '_Sales.csv';
       
        $file = fopen($pathPublic.$filename,"a+");
        try{

            foreach ($attributes as $key => $value) {

                $data = [];
                $data[] = $key;
                $data[] = $value->branch_name;
                $data[] = $value->photographer_name;
                $data[] = $value->room_has_number;
                $data[] = $value->total_amount;
                $data[] = $value->purchase_date;
                $data[] = $value->customer_email;
                $data[] = $value->payment_method;
                $data[] = $value->purchase_from;
                fputcsv($file, $data);
            }

            fclose($file);
        }catch (Exception $e)
        {
            \Log::info(' Errors to insert csv file - '.$e->getMessage());
        }

    }
}
