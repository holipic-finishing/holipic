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

    public function getInfomationCompanyAndTotalAmountDefault($companyId)
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
                    ->select(DB::raw("sum(amount) as total"),DB::raw("DATE_FORMAT(dated,'%Y-%c-%d') as date"), 'currencies.id','currencies.name' ) 
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
            $key = $company['name'];
            
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

    private function createLabelsByTime($time,$timeBefore ,$companyId)
    {

        $date = $this->model->select(DB::raw("DATE_FORMAT(dated,'%Y-%c-%d') as date"))
                            ->where('company_id', $companyId)
                            ->where(DB::raw('dated'), '>=', $timeBefore)
                            ->where(DB::raw('dated'), '<=', $time)
                            ->groupBy('dated')->orderBy('dated', 'asc')->get()->toArray();

        return $date;
    }

    public function getInfomationCompanyAndTotalAmountByTime($request)
    {   
        $companies = $this->model;

        if($request['type'] == 'Day') {
            
            $time = explode("-", $request['date']);
            $date = Carbon::create($time[0], $time[1], $time[2]);

            $dateBefore = Carbon::create($time[0], $time[1], $time[2])->subDays(10)->toDateString();

            $companies = $companies->join('currencies','currencies.id', '=', 'transactions.currency_id')
                                    ->select(DB::raw("sum(amount) as total"),DB::raw("DATE_FORMAT(dated,'%Y-%c-%d') as date"), 'currencies.id','currencies.name');

        } else {

            $timeMonth = explode("-", $request['date']);
            $date = Carbon::create($timeMonth[0], $timeMonth[1], 31 );

            $dateBefore = Carbon::create($timeMonth[0], $timeMonth[1], 1)->subMonths(12);

            $companies = $companies->join('currencies','currencies.id', '=', 'transactions.currency_id')
                                    ->select(DB::raw("sum(amount) as total"),DB::raw("DATE_FORMAT(dated,'%Y-%c-%d') as date"), 'currencies.id','currencies.name'); 
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
            $key = $company['name'];
            
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

}
