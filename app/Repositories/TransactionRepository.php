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
