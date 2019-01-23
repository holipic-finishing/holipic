<?php

namespace App\Repositories;

use App\Models\EwalletWithdraw;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EwalletWithdrawRepository
 * @package App\Repositories
 * @version January 22, 2019, 8:14 am UTC
 *
 * @method EwalletWithdraw findWithoutFail($id, $columns = ['*'])
 * @method EwalletWithdraw find($id, $columns = ['*'])
 * @method EwalletWithdraw first($columns = ['*'])
*/
class EwalletWithdrawRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'amount',
        'bank_account_number',
        'bank_name',
        'account_holder_name',
        'iban',
        'swift_code',
        'status',
        'company_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EwalletWithdraw::class;
    }
}
