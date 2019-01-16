<?php

namespace App\Repositories;

use App\Models\Branch;
use InfyOm\Generator\Common\BaseRepository;
use App\Models\Company;
use Spatie\Activitylog\Models\Activity;
use App\Events\RedisEventActivityLog;

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
        $data = $this->model->with('user')->whereCompanyId(request('companyId'))->get()->toArray();

        return $data;
    }

    public function handleSaveBranchCompany()
    {
        $companyId = request('companyId');
        
        if($companyId && $companyId != '') {

            $user = \App\Models\User::create(
                ['first_name' => 'first_name',
                 'last_name' => 'last_name',
                 'email' => str_random(8).'@gmail.com',
                 'username' => request('information.username'),
                 'password' => bcrypt(request('information.password')),
                 'role_id' => '3'
                ]
            );

            $branch = $this->model->create(
                ['company_id' => $companyId, 
                 'name' => request('information.branchName'),
                 'branch_password' => request('information.password'),
                 'user_id' => $user['id'],
                 'branch_address' => request('information.address'),
                 'branch_phone_number' => request('information.phone')
                ]
            );

            $company = Company::whereId(request('companyId'))->first();

            // Save activity logs
            // $log = Activity::all()->last();
            // $log['user_id'] = $company['owner_id'];
            // $log['description_log'] = 'Add Branch'.' '.$branch['name'];
            // $log->save();

            // event(new \App\Events\RedisEventActivityLog($log));
 
            return [$branch, $company];
        }

        return false;
    }


    public function handleGetBranchCompanyId($company_id){

       return $this->model->select('id','name')->where('company_id',$company_id)->get();

    }
}
