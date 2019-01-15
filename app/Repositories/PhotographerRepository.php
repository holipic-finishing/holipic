<?php

namespace App\Repositories;

use App\Models\Photographer;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PhotographerRepository
 * @package App\Repositories
 * @version January 2, 2019, 10:14 am UTC
 *
 * @method Photographer findWithoutFail($id, $columns = ['*'])
 * @method Photographer find($id, $columns = ['*'])
 * @method Photographer first($columns = ['*'])
*/
class PhotographerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'branch_id',
        'name',
        'phone_number',
        'address',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Photographer::class;
    }

    public function getCompany()
    {
        $company = \App\Models\Company::whereOwnerId(request('userId'))->first();

        return $company;
    }

    //Get photgraphers with company 
    public function handleGetPhotographers()
    {
        $companyId = request('companyId');

        if($companyId && $companyId != '') {
            $data = $this->model->with(['branch' => function($q) use($companyId) {
                                $q->whereCompanyId($companyId);
                    }])->get()->toArray();

            $array = [];

            foreach($data as $value) 
            {
                if(!is_null($value['branch'])){
                    $array[] = $value;
                }
            }
            
            return $array;
        }

        return false;
    }

    //Add Photographer with company branch
    public function handelSavePhotographer()
    {
        $input = request('information');

        //$company = $this->getCompany();

        $data = $this->model->create([
            'branch_id' => $input['branch_id'],
            'name' => $input['name'],
            'phone_number' => $input['phone_number'],
            'address' => $input['address'],
            'status' => $input['status'] == 'Active' ? true : false
        ]);
            
        return $data;
    }

    
}
