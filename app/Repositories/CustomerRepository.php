<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\User;
use InfyOm\Generator\Common\BaseRepository;
use File;

/**
 * Class CustomerRepository
 * @package App\Repositories
 * @version January 5, 2019, 9:11 am UTC
 *
 * @method Customer findWithoutFail($id, $columns = ['*'])
 * @method Customer find($id, $columns = ['*'])
 * @method Customer first($columns = ['*'])
*/
class CustomerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'room',
        'email',
        'password',
        'avatar'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Customer::class;
    }

    public function handelGetCustomers()
    {
        $companyId = request('companyId');

        $data = [];
        
        if(!empty($companyId)) {

            $customers = $this->model
                            ->with('user')
                            ->with('room')
                            ->with(['branch' => function($q) use ($companyId) {
                                
                                $q->whereCompanyId($companyId);
                            
                            }])->get()->toArray();


            foreach($customers as $customer) 
            {
                if($customer['branch'] != null)
                {
                    $fileName = $this->createLinkAvatar($customer['avatar']);
                    $customer['avatar'] = asset('customer_avatars/' . $fileName);
                    $data[] = $customer;
                }
            }

            return $data;
        }

        return false;
    }

    function createLinkAvatar($link){
        $components = explode("/", $link);
        $fileName = end($components);
        return $fileName;
    }

    public function handleUpdateCustomer($id)
    {
        $customer = $this->model->findOrFail($id); 

        $input = request('params'); 

        if(request('params.status')) {
            $input = request('params.status') == 'Active' ? ['status' => true] : ['status' => false] ;
        }

        if (request('params.email')) {
            User::where('id', '=', $customer->user_id)->update($input);
        }

        if(request()->file('avatar')) {

            $image = request()->file('avatar');

            $typeFile = $image->getClientOriginalExtension();

            if($typeFile != 'jpg' && $typeFile != 'png' && $typeFile != 'jpeg'){
                return false;
            }

            if (! File::exists(public_path()."/images/customer")) {
                File::makeDirectory(public_path()."/images/customer");
            }

            $name = time().'_'.$customer['id'].'_'.$image->getClientOriginalName();
            $input = ['avatar' => '/images/customer/'.$name];

            $destinationPath = public_path('/images/customer');
            $image->move($destinationPath, $name);
        }

        if(!is_null($customer))
        {
            $customer = $customer->update($input);
            return $customer;
        }

        return false;
    }

    public function handelGetBranchCustomers($input)
    {
        $companyId = $input['company_id'];
        $user_id = $input['id']; 

        $data = [];
        
        if($companyId && $companyId != '') {
            $customers = $this->model
                                ->with('user')
                                ->with('room')
                                ->with(['branch' => function($q) use ($companyId, $user_id) {
                                                     $q->whereCompanyId($companyId)->whereUserId($user_id);
                                        }])->get()->toArray();

            foreach($customers as $customer) 
            {
                if($customer['branch'] != null)
                {
                    $data[] = $customer;
                }
            }

            return $data;
        }

        return false;
    }

    public function handleUpdateBranchCustomer($id)
    {
        $customer = $this->model->findOrFail($id);

        $input = request('params');

        if(request('params.status')) {
            $input = request('params.status') == 'Active' ? ['status' => true] : ['status' => false] ;
        }

        if (request('params.email')) {
            User::where('id', '=', $customer->user_id)->update($input);
        }

        if(request()->file('avatar')) {

            $image = request()->file('avatar');

            $typeFile = $image->getClientOriginalExtension();

            if($typeFile != 'jpg' && $typeFile != 'png' && $typeFile != 'jpeg'){
                return false;
            }

            $name = time().'_'.$customer['id'].'_'.$image->getClientOriginalName();
            $input = ['avatar' => '/images/customer/'.$name];

            $destinationPath = public_path('/images/customer');
            $image->move($destinationPath, $name);
        }

        if(!is_null($customer))
        {
            $customer = $customer->update($input);

            return $customer;
        }

        // return false;
    }

    public function handleDeleteBranchCustomer($id)
    {
        $customer = $this->model->find($id); 
        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        $user = User::where('id', '=', $customer->user_id)->first(); 
        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->delete();
        $customer->delete();

        return true;
    }
}
