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
        $company = $this->getCompany();

        if(!empty($company)) {
            // $data = $this->model->with('branch')->whereCompanyId($company['id'])->get()->toArray();
            $data = $this->model->with(['branch' => function($q) use($company) {
                                $q->whereCompanyId($company['id']);
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


    /****** Get name, id photographer by branch ******/
    public function handelGetPhotographersByBranch($branch_id){

        return $this->model->select('id','name')->where('branch_id',$branch_id)->get();

    }
}
