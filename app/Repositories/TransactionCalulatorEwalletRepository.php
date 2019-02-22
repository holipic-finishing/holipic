<?php

namespace App\Repositories;

use App\Models\TransactionCalulatorEwallet;
use InfyOm\Generator\Common\BaseRepository;
use DB;

/**
 * Class TransactionCalulatorEwalletRepository
 * @package App\Repositories
 * @version January 30, 2019, 7:02 am UTC
 *
 * @method TransactionCalulatorEwallet findWithoutFail($id, $columns = ['*'])
 * @method TransactionCalulatorEwallet find($id, $columns = ['*'])
 * @method TransactionCalulatorEwallet first($columns = ['*'])
*/
class TransactionCalulatorEwalletRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'amount',
        'status',
        'system_fee',
        'credit_card_fee',
        'invoice',
        'user_id',
        'currency_id',
        'company_id',
        'dated'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TransactionCalulatorEwallet::class;
    }


    /*
    *   Target : Get all table transaction belongs to company id 
    */

    public function eWalletTransactionHistory($attribute,$status){

        if(isset($attribute['company_id'])){
            $results =  $this->scopeQuery(function($query) use($attribute, $status){


                $query = $query->select('id','title','dated','amount','status','system_fee')
                                ->with(['transactionexchange' => function($query){
                                    $query->select(['exchange_rate_to_dollar','transaction_id']);
                                }])
                                ->where('company_id',$attribute['company_id']);
                $query = $query->orderBy('dated', 'desc');
                return $query;
            });

            $results = $this->transformTransactionHistory($results->get());

            return $results;
        }

    }

    public function transformTransactionHistory($attributes){
        foreach ($attributes as $key => $value) {  
            $new_amount = round(($value->amount - $value->system_fee) * $value->transactionexchange->exchange_rate_to_dollar,3);
            $attributes[$key]->new_amount = $new_amount;
        }
        return $attributes;

    }

    public function calculatorEwallet($attribute){
        if(isset($attribute['company_id'])){

            $company_id = $attribute['company_id'];

            $amountIncomes =  $this->scopeQuery(function($query) use($company_id){

                $query = $query->with('transactionexchange')
                                ->where('company_id',$company_id)
                                ->where('status','RECIVED');
                return $query;
            })->get();

            $totalIncome = 0 ; 

            $totalSystemFee = 0;

            foreach ($amountIncomes as $key => $amountIncome) {
                $totalIncome += ($amountIncome->amount * $amountIncome->transactionexchange->exchange_rate_to_dollar);

                $totalSystemFee += ($amountIncome->system_fee * $amountIncome->transactionexchange->exchange_rate_to_dollar);
            }

            $amountOutcomes =  $this->scopeQuery(function($query) use($company_id){

                $query = $query->with('transactionexchange')
                                ->where('company_id',$company_id)
                                ->where('status','DONE');
                return $query;
            })->get();

            $totalOutcome = 0 ; 

            foreach ($amountOutcomes as $key => $amountOutcome) {
                $totalOutcome += ($amountOutcome->amount * $amountOutcome->transactionexchange->exchange_rate_to_dollar);
            }

            $total = $totalIncome - $totalSystemFee - $totalOutcome;
            $total = round($total,3);
            return $total;
        }
    }
}
