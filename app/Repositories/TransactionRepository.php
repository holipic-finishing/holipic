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
        'type',
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

    //function show chart default from now with 10 day before
    public function getInformationCompanyAndTotalAmountDefault($companyId)
    {
        //DB::raw("DATE_FORMAT(dated,'%M %Y %D') as months")
        // $companies = $this->model->select(DB::raw("sum(amount) as total"),DB::raw("DATE_FORMAT(dated,'%Y-%c-%d') as date"), 'currency_id') 
        // ->where('company_id', $companyId)
        // ->where(DB::raw('dated'), '>=', Carbon::now()->subDays(10))
        //         ->where(DB::raw('dated'), '<=', Carbon::now())
        // ->groupBy('date', 'currency_id')
        // ->orderBy('date', 'asc')
        // ->get()->toArray();

        $companies = $this->model->join('currencies','currencies.id', '=', 'transactions.currency_id')
                    ->select(DB::raw("sum(amount) as total"),DB::raw("DATE_FORMAT(dated,'%Y-%c-%d') as date"), 'currencies.id','currencies.symbol' ) 
                    ->where('company_id', $companyId)
                    ->where(DB::raw('dated'), '>=', Carbon::now()->subDays(10))
                    ->where(DB::raw('dated'), '<=', Carbon::now())
                    ->groupBy('date', 'currency_id')
                    ->orderBy('date', 'asc')
                    ->get()->toArray();

        // $array = [];
        // foreach($companies as $company)
        // {
        //     $array[$company['currency_id']][] = $company;
        // }
        

        $data = [];

        $labels = $this->createLabels(null,$companyId);

        $length = count($labels);

        foreach($companies as $company){
            $date = str_replace(' 00:00:00', '', $company['date']);
            $key = $company['symbol'];
            
            for($i = 0; $i < $length; $i++){
                if(!isset($data[$key][$labels[$i]['date']])) {
                    $data[$key][$labels[$i]['date']] = 0;
                }
            }
            $data[$key][$date] = $company['total'];
        }

        return [
            'labels' => $labels,
            'data' => $data 
        ]; 
    }

    //function show label date default for chart

    private function createLabels($date = null, $companyId)
    {
        // if(is_null($date)){
        //     $date = now();
        // }
        // return [
        //     now()->subDays(10)->format('Y-m-d'),
        //     now()->subDays(9)->format('Y-m-d'),
        //     now()->subDays(8)->format('Y-m-d'),
        //     now()->subDays(8)->format('Y-m-d'),
        //     now()->subDays(7)->format('Y-m-d'),
        //     now()->subDays(6)->format('Y-m-d'),
        //     now()->subDays(5)->format('Y-m-d'),
        //     now()->subDays(4)->format('Y-m-d'),
        //     now()->subDays(3)->format('Y-m-d'),
        //     now()->subDays(2)->format('Y-m-d'),
        //     now()->subDays(1)->format('Y-m-d'),
        //     now()->format('Y-m-d'),
        // ];

        $date = $this->model->select(DB::raw("DATE_FORMAT(dated,'%Y-%c-%d') as date"))->where('company_id', $companyId)
                            ->where(DB::raw('dated'), '>=', Carbon::now()->subDays(10))
                            ->where(DB::raw('dated'), '<=', Carbon::now())
                            ->groupBy('dated')->orderBy('dated', 'asc')->get()->toArray();

        return $date;
    }

    //function show label date default with time for chart

    private function createLabelsByTime($time,$timeBefore ,$companyId)
    {

        $date = $this->model->select(DB::raw("DATE_FORMAT(dated,'%Y-%c-%d') as date"))
                            ->where('company_id', $companyId)
                            ->where(DB::raw('dated'), '>=', $timeBefore)
                            ->where(DB::raw('dated'), '<=', $time)
                            ->groupBy('dated')->orderBy('dated', 'asc')->get()->toArray();

        return $date;
    }

    //function show chart with day or month

    public function getInformationCompanyAndTotalAmountByTime($request)
    {   
        $companies = $this->model;

        if($request['type'] == 'Day') {
            
            $time = explode("-", $request['date']);
            $date = Carbon::create($time[0], $time[1], $time[2]);

            $dateBefore = Carbon::create($time[0], $time[1], $time[2])->subDays(10)->toDateString();

            $companies = $companies->join('currencies','currencies.id', '=', 'transactions.currency_id')
                                    ->select(DB::raw("sum(amount) as total"),DB::raw("DATE_FORMAT(dated,'%Y-%c-%d') as date"), 'currencies.id','currencies.symbol');

        } else {

            $timeMonth = explode("-", $request['date']);
            $date = Carbon::create($timeMonth[0], $timeMonth[1], 31 );

            $dateBefore = Carbon::create($timeMonth[0], $timeMonth[1], 1)->subMonths(12);

            $companies = $companies->join('currencies','currencies.id', '=', 'transactions.currency_id')
                                    ->select(DB::raw("sum(amount) as total"),DB::raw("DATE_FORMAT(dated,'%Y-%c-%d') as date"), 'currencies.id','currencies.symbol'); 
        }

        $companies = $companies->where('company_id', $request['companyId'])
                            ->where(DB::raw('dated'), '>=', $dateBefore)
                            ->where(DB::raw('dated'), '<=', $date)
                            ->groupBy('date', 'currency_id')->orderBy('date', 'asc')
                            ->get()->toArray();

        $data = [];

        $labels = $this->createLabelsByTime($date, $dateBefore, $request['companyId']);

        $length = count($labels);

        foreach($companies as $company){
            $date = str_replace(' 00:00:00', '', $company['date']);
            $key = $company['symbol'];
            
            for($i = 0; $i < $length; $i++){
                if(!isset($data[$key][$labels[$i]['date']])) {

                    $data[$key][$labels[$i]['date']] = 0;
                }
            }
            $data[$key][$date] = $company['total'];
        }

        return [
            'labels' => $labels,
            'data' => $data 
        ]; 

        // return $company;
    }


    public function reportUserDaily($attributes,$dates){

        if(isset($attributes['start_day']) && isset($attributes['end_day']) )
        {
            $startDay = Carbon::parse($attributes['start_day'])->format('Y-m-d');
            $endDay = Carbon::parse($attributes['end_day'])->format('Y-m-d');
        }
       
        $transactions = $this->model->select(DB::raw('SUM(system_fee) AS total, dated'))
                                    ->whereBetween(DB::raw('date(dated)'),[$startDay,$endDay])
                                    ->where('type','1')
                                    ->where('status','completed')
                                    ->groupBy('dated')
                                    ->get();


        foreach ($dates as $key => $date) {

            foreach ($transactions as $k_v => $value) {
            
                $day = Carbon::parse($value->dated)->format('Y-m-d');

                if($key == $day) {
                    $dates[$key]['total'] = $value->total;
                    break;

                } else {
                    $dates[$key]['total'] = 0;
                }
            }              
        }

        return $dates;
    }

    public function reportUserMonth($attributes,$dayInMonth){

        if(isset($attributes['month']))
        {
            $month = Carbon::parse($attributes['month'])->format('Y-m');
        }

        $timeMonth = explode("-", $attributes['month']);

        $transactions = $this->model->select(DB::raw('SUM(system_fee) AS total, dated'))
                                    ->whereYear('dated',$timeMonth[0])
                                    ->whereMonth('dated',$timeMonth[1])
                                    ->where('type','1')
                                    ->where('status','completed')
                                    ->groupBy('dated')->get();

        foreach ($dayInMonth as $key => $date) {

            foreach ($transactions as $k_v => $value) {
            
                $day = Carbon::parse($value->dated)->format('Y-m-d');

                if($key == $day) {
                    $dayInMonth[$key]['total'] = $value->total;
                    break;

                } else {
                    $dayInMonth[$key]['total'] = 0;
                }
            }              
        }

        return $dayInMonth;
    }

    public function reportUserYear($attributes,$monthInYear){

        if(isset($attributes['year']))
        {
            $year = Carbon::parse($attributes['year'])->format('Y');
        }

        $timeYear = explode("-", $attributes['year']);

        $transactions = $this->model->select(
                                        DB::raw('SUM(system_fee) AS total'),
                                        DB::raw("DATE_FORMAT(dated,'%Y-%c') as date")
                                    )
                                    ->whereYear('dated',$timeYear[0])
                                    ->where('type','1')
                                    ->where('status','completed')
                                    ->groupBy('date')->get();

        foreach ($monthInYear as $key => $date) {

            foreach ($transactions as $k_v => $value) {
            
                if($key == $value->date) {
                    $monthInYear[$key]['total'] = $value->total;
                    break;

                } else {
                    $monthInYear[$key]['total'] = 0;
                }
            }              
        }

       return $monthInYear;

    }

    public function reportUserWeek($dayWeek){

        $startDay   = Carbon::today()->subDays(27)->format('Y-m-d');

        $endDay     = Carbon::today()->format('Y-m-d');


        $transactions = $this->model->select(DB::raw('SUM(system_fee) AS total, dated'))
                                ->whereBetween(DB::raw('date(dated)'),[$startDay,$endDay])
                                ->groupBy('dated')
                                ->where('type','1')
                                ->where('status','completed')
                                ->get();                

        foreach ($dayWeek as $key => $date) {

             $total = 0;

            foreach ($transactions as $k_v => $value) {
                
                $day = Carbon::parse($value->dated)->format('Y-m-d');
                if($date['startOfWeek'] <= $day && $day <= $date['endOfWeek']) {
                    $total = $total + $value->total;  
                } 
                else {
                    $dayWeek[$key]['total'] = 0;
                   
                }
            }

            $dayWeek[$key]['total'] = $total;
       
        }    
        
        return $dayWeek;        

    }

    /**
    
        TODO:
        - Get Lists Histories Transaction
    
     */
    
    public function getHistoriesTransaction(){
        $now = \Carbon\Carbon::today();
        $dateBefore7Days = $now->subDays(7); 

        $results = DB::table('transactions as t')
                    ->join('users as u', 'u.id', '=', 't.user_id')
                    ->join('currencies as cu', 'cu.id', '=', 't.currency_id')
                    ->join('packages as p', 'p.id', '=', 'u.package_id')
                    ->where('t.dated', '>=', $dateBefore7Days)
                    ->orderBy('t.amount', 'asc')
                    ->select('t.*','cu.symbol', 'cu.country','u.company_name', 'u.email', 'u.first_name', 'u.last_name','p.package_name')
                    ->get();
        $results = $this->transform($results);

        return $results;
    }  

    /**
    
        TODO:
        - create new_field from old_filed
        
     */
    
    public function transform($results){
        foreach ($results as $key => $result) {
            if($result->type == 1){
                $results[$key]->type = 'Income';
            }else{
                $results[$key]->type = 'Outcome';
            }
            $results[$key]->amount_with_symbol = $result->amount ." ".$result->symbol;             
            $results[$key]->system_fee_with_symbol = $result->system_fee ." ".$result->symbol;         
            $results[$key]->credit_card_fee_with_symbol = $result->credit_card_fee ." ".$result->symbol;             
            $results[$key]->fullname = $result->first_name ." ".$result->last_name;             
        }

        return $results;
    } 


}
