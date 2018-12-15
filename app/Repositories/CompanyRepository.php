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
        // $results = DB::table('companies as c')
        //             ->join('users as u', 'u.id', '=', 'c.owner_id')
        //             ->join('packages as p', 'p.id', '=', 'u.package_id')
        //             ->select('c.id as id', 'c.name', 'c.description', 'c.address', 'c.logo', 'u.email', 'p.package_name')
        //             ->get();

        $results = $this->model->with(['files','user.package','transactions'])->get(); 

        foreach ($results as $key => $value) {
            $total_file_size = 0;
            $total_system_fee = 0;
            $total_amount = 0;
            foreach ($value->files as $item) {
                $total_file_size += $item->file_size;
            }
            foreach ($value->transactions as $item) {
                $total_system_fee += $item->system_fee;
                $total_amount += $item->amount;
            }
            $results[$key]->total_file_size = $total_file_size;
            $results[$key]->total_income_fee = $total_system_fee;
            $results[$key]->total_income = $total_amount - $total_system_fee;
            $results[$key]->email = $value->user->email;
            $results[$key]->package_name = $value->user->package->package_name;
        }

        return $results;
    }

    public function search($input){
        $results = DB::table('companies as c')
                    ->join('users as u', 'u.id', '=', 'c.owner_id')
                    ->join('packages as p', 'p.id', '=', 'u.package_id')
                    ->where('c.name', 'like', '%'.$input['company_name'].'%')
                    ->select('c.id as id', 'c.name', 'c.description', 'c.address', 'c.logo', 'u.email', 'p.package_name')
                    ->get();
        return $results;
    }
}
