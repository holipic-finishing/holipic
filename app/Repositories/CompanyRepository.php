<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\User;
use InfyOm\Generator\Common\BaseRepository;
use DB;

/**
 * Class CompanyRepository
 * @package App\Repositories
 * @version December 10, 2018, 3:23 am UTC
 *
 * @method Company findWithoutFail($id, $columns = ['*'])
 * @method Company find($id, $columns = ['*'])
 * @method Company first($columns = ['*'])
*/
class CompanyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'address',
        'user_id',
        'logo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Company::class;
    }


    public function getCompanies(){
        $results = DB::table('companies as c')
                    ->join('users as u', 'u.id', '=', 'c.owner_id')
                    ->select('c.id as id', 'c.name', 'c.description', 'c.address', 'c.logo', 'u.email')
                    ->get();
        return $results;
    }
}
