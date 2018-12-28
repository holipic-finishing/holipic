<?php

namespace App\Repositories;

use App\Models\TransactionExchange;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TransactionExchangeRepository
 * @package App\Repositories
 * @version December 28, 2018, 8:06 am UTC
 *
 * @method TransactionExchange findWithoutFail($id, $columns = ['*'])
 * @method TransactionExchange find($id, $columns = ['*'])
 * @method TransactionExchange first($columns = ['*'])
*/
class TransactionExchangeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'transaction_id',
        'exchange_rate_dollar'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TransactionExchange::class;
    }
}
