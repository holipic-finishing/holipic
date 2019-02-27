<?php

namespace App\Repositories;

use App\Models\Photographer;
use InfyOm\Generator\Common\BaseRepository;
use File;

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
        $array = [];

        if(request('companyId') && !empty(request('companyId'))) {

            $companyId = request('companyId');

            $data = $this->model->with(['branch' => function($q) use($companyId) {
                                $q->whereCompanyId($companyId);
                    }]);

            if(request('search') && !empty(request('search'))) {
                $data = $data->where('name', 'like', '%'.request('search').'%');
            }

            $data = $data->get()->toArray();
        }

        if(request('branchId') && !empty(request('branchId'))) {

            $branchId = request('branchId');

            $data = $this->model->with(['branch' => function($q) use($branchId) {
                                $q->whereId($branchId);
                    }])->get()->toArray();
        }

        if($data && !empty($data)) {

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

    /**
     * [handelSavePhotographer description]
     * @return [type] [description]
     */
    
    public function handelSavePhotographer()
    {
        $input = request()->all();

        $identification = request()->file('identification');

        $avatar = request()->file('avatar');

        if(!File::exists(public_path() . "/photographers/avatars")) {
            $oldmask = umask(0);
            File::makeDirectory(public_path() . "/photographers", $mode = 0777, true, true);
            File::makeDirectory(public_path() . "/photographers/avatars", $mode = 0777, true, true);
            File::makeDirectory(public_path() . "/photographers/identification", $mode = 0777, true, true);
            umask($oldmask);
        }

        if($identification) {
            $nameIdentification = time().'_'.'identification'.'_'.$input['phone_number'].'_'.$input['name'];
            $input['identification'] = 'photographers/identification/'.$nameIdentification;

            $destinationPath = public_path('photographers/identification');
            $identification->move($destinationPath, $nameIdentification);
        }

        if($avatar) {
            $nameAvatar = time().'_'.'avatar'.'_'.$input['phone_number'].'_'.$input['name'];
            $input['avatar'] = 'photographers/avatars/'.$nameAvatar;

            $destinationPath = public_path('/photographers/avatars');
            $avatar->move($destinationPath, $nameAvatar);
        }

        $data = $this->model->create([
            'branch_id' => $input['branch_id'],
            'name' => $input['name'],
            'phone_number' => $input['phone_number'],
            'address' => $input['address'],
            'email' => $input['email'],
            'avatar' => isset($input['avatar']) ? $input['avatar'] : '' ,
            'identification_card' => isset($input['identification']) ? $input['identification'] : '',
            'status' => $input['status'] == 'Active' ? true : false
        ]);

        return $data;
    }


    /****** Get name, id photographer by branch ******/
    public function handelGetPhotographersByBranch($branch_id){

        return $this->model->select('id','name')->where('branch_id',$branch_id)->get();

    }

    /**
     * [handleUpdateIdentification description]
     * @param  [string] $image        [description]
     * @param  [string] $photographer [description]
     * @return [identification_card]
     */
    public function handleUpdateIdentification($image, $photographer)
    {
        if(File::exists(public_path() .'/'. $photographer['identification_card'])) {
             
            File::delete(public_path() .'/' .$photographer['identification_card']);
        }

        $name = time().'_'.'identification'.'_'.$photographer['phone_number'].'_'.$photographer['name'];
        $identification = 'photographers/identification/'.$name;

        $destinationPath = public_path('photographers/identification');
        $image->move($destinationPath, $name);

        return ['identification_card' => $identification];
    }

     /**
     * [handleUpdateAvatar description]
     * @param  [string] $image        [description]
     * @param  [string] $photographer [description]
     * @return [avatar]
     */
    public function handleUpdateAvatar($image, $photographer)
    {
        if(File::exists(public_path() .'/'. $photographer['avatar'])) {

            File::delete(public_path().'/' . $photographer['avatar']);
        }

        $name = time().'_'.'avatar'.'_'.$photographer['phone_number'].'_'.$photographer['name'];
        $avatar = 'photographers/avatars/'.$name;

        $destinationPath = public_path('photographers/avatars');
        $image->move($destinationPath, $name);

        return ['avatar' => $avatar];
    }

    public function handleGetDetailPhotographer($photographerId)
    {
        if($photographerId) {

            $photographer = $this->scopeQuery(function($query) use ($photographerId){
                                $query = $query->with('branch')->whereId($photographerId);
                                return $query;
                            })->first();

            return $photographer;
        }

        return false; 
    }
}
