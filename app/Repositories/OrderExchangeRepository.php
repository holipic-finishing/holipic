<?php

namespace App\Repositories;

use App\Models\OrderExchange;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class OrderExchangeRepository
 * @package App\Repositories
 * @version January 9, 2019, 8:20 am UTC
 *
 * @method OrderExchange findWithoutFail($id, $columns = ['*'])
 * @method OrderExchange find($id, $columns = ['*'])
 * @method OrderExchange first($columns = ['*'])
*/
class OrderExchangeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'order_id',
        'exchange_rate_to_dollar'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return OrderExchange::class;
    }
}
