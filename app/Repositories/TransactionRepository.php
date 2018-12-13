<?php

namespace App\Repositories;

use App\Models\Transaction;
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

    public function getTotalAmountCompany($companyId)
    {
        // DB::raw("DATE_FORMAT(dated,'%M %Y %D') as months")
        $company = $this->model->select(DB::raw("sum(amount) as total"),'dated as date', 'currency_id')
        ->where('company_id', $companyId)
        ->where(DB::raw('DAY(dated)'), '>=', Carbon::now()->subDays(10)->day)
        ->where(DB::raw('DAY(dated)'), '<=', Carbon::now()->day)
        ->whereMonth('dated', Carbon::now()->month)
        ->groupBy('date', 'currency_id')->orderBy('date', 'asc')
        ->get()->toArray();
        // dd($company);

        return $company;
    }

    public function getTotalAmountCompanyByTime($request)
    {   
        $company = $this->model;

        if($request['type'] == 'Day') {
            
            $time = explode("-", $request['date']);
            $date = Carbon::create($time[0], $time[1], $time[2]);

            $dateBefore = Carbon::create($time[0], $time[1], $time[2])->subDays(10)->toDateString();

            $company = $company->select(DB::raw("sum(amount) as total"),'dated as date')
                ->where('company_id', $request['companyId'])
                ->where('currency_id', 3);                     
        } else {

            $timeMonth = explode("-", $request['date']);
            $date = Carbon::create($timeMonth[0], $timeMonth[1], 31 );

            $dateBefore = Carbon::create($timeMonth[0], $timeMonth[1], 1)->subMonths(12);

            $company = $company->select(DB::raw("sum(amount) as total"), DB::raw("DATE_FORMAT(dated,'%Y/%c/%d') as date"))
                ->where('company_id', $request['companyId'])
                ->where('currency_id', 3);
        }

        $company = $company->where(DB::raw('dated'), '>=', $dateBefore)
                            ->where(DB::raw('dated'), '<=', $date)
                            ->groupBy('date')->orderBy('date', 'asc')
                            ->get()->toArray();

        return $company;
    }


    public function reportUserDaily($attributes,$dates){

        if(isset($attributes['start_day']) && isset($attributes['end_day']) )
        {
            $startDay = Carbon::parse($attributes['start_day'])->format('Y-m-d');
            $endDay = Carbon::parse($attributes['end_day'])->format('Y-m-d');
        }
       
        $transactions = $this->model->select(DB::raw('SUM(system_fee) AS total, dated'))->whereBetween(DB::raw('date(dated)'),[$startDay,$endDay])->groupBy('dated')->get();


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

        $transactions = $this->model->select(DB::raw('SUM(system_fee) AS total'),
                                            DB::raw("DATE_FORMAT(dated,'%Y-%c') as date"))
                                    ->whereYear('dated',$timeYear[0])
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
                                ->groupBy('dated')->get();                

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

}
