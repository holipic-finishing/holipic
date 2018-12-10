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

        $company = $this->model->select(DB::raw("sum(amount) as total"),'dated'
            // DB::raw("DATE_FORMAT(dated,'%M %Y %D') as months")
        )->where('company_id', $companyId)->where('currency_id', 3)
        ->whereMonth('dated', Carbon::now()->month)
        ->groupBy('dated')->orderBy('dated', 'asc')
        ->get()->toArray();
        
        return $company;
    }
}
