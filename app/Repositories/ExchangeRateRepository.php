<?php

namespace App\Repositories;

use App\Models\ExchangeRate;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ExchangeRateRepository
 * @package App\Repositories
 * @version December 28, 2018, 8:03 am UTC
 *
 * @method ExchangeRate findWithoutFail($id, $columns = ['*'])
 * @method ExchangeRate find($id, $columns = ['*'])
 * @method ExchangeRate first($columns = ['*'])
*/
class ExchangeRateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'from_currency_id',
        'to_currency_id',
        'rate'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ExchangeRate::class;
    }
}
