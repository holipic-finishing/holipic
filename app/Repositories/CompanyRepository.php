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

    /**
    
        TODO:
        - function to get list companies 
    
    */
    
    public function getCompanies(){
        $results = DB::table('transactions as t')
                    ->rightJoin('companies as c', 't.company_id', '=', 'c.id')
                    ->join('users as u', 'u.id', '=', 'c.owner_id')
                    ->join('packages as p', 'p.id', '=', 'u.package_id')

                    ->select('c.id as id', 'c.name', 'c.description', 'c.address', 'c.logo', 'u.email', 'p.package_name', DB::raw('sum((t.amount * p.fee /100)) as system_fee') )
                   ->groupBy('t.company_id', 'c.id','c.name', 'c.description' ,'c.address', 'c.logo', 'u.email', 'p.package_name')
                    ->get();

        $results = $this->transform($results);

        return $results;
    }

    /**
        TODO:
        - function to search companies by company_name, fullname, email ;  filter package name
        -@param : keywords search, package_name

    */
    
    public function search($input){

        $results =  DB::table('transactions as t')
                    ->rightJoin('companies as c', 't.company_id', '=', 'c.id')
                    ->join('users as u', 'u.id', '=', 'c.owner_id')
                    ->join('packages as p', 'p.id', '=', 'u.package_id');

        if($input['keywords'] != null){
            $results = $results->where('name', 'like', '%'.$input['keywords'].'%')
                                ->orwhere('email', 'like', '%'.$input['keywords'].'%')
                                ->orWhereRaw("concat(first_name, ' ', last_name) like '%{$input['keywords']}%' ");
        }

        elseif($input['filterPackage'] != null){
            if($input['filterPackage'] != "All"){
                $results = $results->where('p.package_name','=', $input['filterPackage']);
            }
        }
        
        $results = $results->select('c.id as id', 'c.name', 'c.description', 'c.address', 'c.logo', 'u.email', 'p.package_name', DB::raw('sum((t.amount * p.fee /100)) as system_fee') )
                   ->groupBy('t.company_id', 'c.id','c.name', 'c.description' ,'c.address', 'c.logo', 'u.email', 'p.package_name')
                    ->get();

        $results = $this->transform($results);
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


        return $results;
    }

    /**
    
       TODO:
        - create new_field from old_filed
       
     */
    
    public function transform($results){
        foreach ($results as $key => $result) {      
            $results[$key]->fullname = $result->first_name ." ".$result->last_name;             
        }

        return $results;
    } 

}
