<?php

namespace App\Repositories;

use App\Models\Customer;
use InfyOm\Generator\Common\BaseRepository;

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
        $company = \App\Models\Company::whereOwnerId(request('userId'))->first();
        $data = [];
        
        if(!empty($company)) {
            $customers = $this->model->with(['branch' => function($q) use ($company) {
                                     $q->whereCompanyId($company['id']);
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

    public function handleUpdateCustomer($id)
    {
        $customer = $this->model->findOrFail($id);

        $input = request('params');

        if(request('params.status')) {
            $input = request('params.status') == 'Active' ? ['status' => true] : ['status' => false] ;
        }

        if(request()->file('avatar')) {
            $image = time().'_'.request()->file('avatar')->getClientOriginalName();
            $input = ['avatar' => $image];
        }

        if(!is_null($customer))
        {
            $customer = $customer->update($input);

            return $customer;
        }

        return false;
    }
}
