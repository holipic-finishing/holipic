<?php

namespace App\Repositories;

use App\Models\Branch;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BranchRepository
 * @package App\Repositories
 * @version January 2, 2019, 4:19 am UTC
 *
 * @method Branch findWithoutFail($id, $columns = ['*'])
 * @method Branch find($id, $columns = ['*'])
 * @method Branch first($columns = ['*'])
*/
class BranchRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Branch::class;
    }

    public function handleGetBranchesCompany()
    {
        // $data = $this->model->whereUserId(request('userId'))->get();
        $data = $this->model->with('user')->whereUserId(request('userId'))->get()->toArray();
 
        return $data;
    }

    public function handleSaveBranchCompany()
    {
        $company = \App\Models\Company::whereOwnerId(request('userId'))->first();
        
        if(!empty($company)) {

            $branch = $this->model->create(
                ['company_id' => $company['id'], 
                 'name' => request('information.branchName'),
                 'branch_password' => request('information.password'),
                 'user_id' => request('userId'),
                 'branch_address' => request('information.address'),
                 'branch_phone_number' => request('information.phone')
                ]
            );

            $user = \App\Models\User::create(
                ['first_name' => 'first_name',
                 'last_name' => 'last_name',
                 'email' => str_random(8).'@gmail.com',
                 'username' => request('information.username'),
                 'password' => bcrypt(request('information.password')),
                 'role_id' => '3'
                ]
            );
            
            return $branch;
        }

        return false;
    }


    public function handleGetBranchCompanyId($company_id){

       return $this->model->select('id','name')->where('company_id',$company_id)->get();

    }
}
