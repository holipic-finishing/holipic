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
        $data = $this->model->whereUserId(request('userId'))->get();
        
        return $data;
    }

    public function handleSaveBranchCompany()
    {
        $company = \App\Models\Company::whereOwnerId(request('userId'))->first();
        
        if(!empty($company)) {

            $branch = $this->model->create(
                ['company_id' => $company['id'], 
                 'branch_name' => request('information.branchName'),
                 'username' => request('information.username'),
                 'password' => request('information.password'),
                 'user_id' => request('userId'),
                 'branch_address' => request('information.address'),
                 'branch_phone_number' => request('information.phone')
                ]
            );
            
            return $branch;
        }

        return false;
    }
}
