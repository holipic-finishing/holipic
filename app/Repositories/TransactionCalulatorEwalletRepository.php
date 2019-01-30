<?php

namespace App\Repositories;

use App\Models\TransactionCalulatorEwallet;
use InfyOm\Generator\Common\BaseRepository;

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
}
