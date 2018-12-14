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
        $results = DB::table('transactions as t')
                    ->rightJoin('companies as c', 't.company_id', '=', 'c.id')
                    ->join('users as u', 'u.id', '=', 'c.owner_id')
                    ->join('packages as p', 'p.id', '=', 'u.package_id')
                    ->select('c.id as id', 'c.name', 'c.description', 'c.address', 'c.logo', 'u.email', 'p.package_name', DB::raw('sum((t.amount * p.fee /100)) as system_fee') )
                   ->groupBy('t.company_id', 'c.id','c.name', 'c.description' ,'c.address', 'c.logo', 'u.email', 'p.package_name')
                    ->get();
                    // dd($results);
        return $results;
    }

    public function search($input){
        $results = DB::table('companies as c')
                    ->join('users as u', 'u.id', '=', 'c.owner_id')
                    ->join('packages as p', 'p.company_id', '=', 'c.id')
                    ->where('name', 'like', '%'.$input['company_name'].'%')
                    ->select('c.id as id', 'c.name', 'c.description', 'c.address', 'c.logo', 'u.email', 'p.package_name')
                    ->get();
        return $results;
    }

    public function handleTransaction($companyId){
         $results = DB::table('transactions as t')
                    ->rightJoin('companies as c', 't.company_id', '=', 'c.id')
                    ->join('users as u', 'u.id', '=', 'c.owner_id')
                    ->join('packages as p', 'p.id', '=', 'u.package_id')
                    ->select('c.id as company_id', 't.amount', 'p.fee','c.name', 'c.description', 'c.address', 'c.logo', 'u.email', 'p.package_name', DB::raw('(t.amount * p.fee /100) as system_fee') )
                    ->where('t.company_id', $companyId)
                    ->get();
        // dd($results);

        return $results;
    }
}
