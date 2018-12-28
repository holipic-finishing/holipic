<?php

namespace App\Repositories;

use App\Models\Package;
use App\Models\Setting;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PackageRepository
 * @package App\Repositories
<<<<<<< HEAD
 * @version December 7, 2018, 12:34 pm UTC
=======
 * @version December 7, 2018, 3:44 am UTC
>>>>>>> 631723baa105c8a24d83155a812b37acfd07c6b3
 *
 * @method Package findWithoutFail($id, $columns = ['*'])
 * @method Package find($id, $columns = ['*'])
 * @method Package first($columns = ['*'])
*/
class PackageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'package_name',
        'short_description',
        'full_description',
        'fee',
        'secure_storage',
        'file_upload',
        'minimum_user',
        'max_user',
        'company_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Package::class;
    }

    public function getPackage(){

        $data = $this->model->get();
        return $data;
     }


    public function countPackages(){

        $data = $this->model->withCount('users')->get()->toArray();

        $count_packages = 0;

        $array_data = [];

        foreach ($data as $key => $value) {

            if($value['package_name']=="Basic"){
                if($value['users_count'])
                {
                    $array_data['count_basic'] = $value['users_count'];
                }
            }

            if($value['package_name']=="Pro"){
                if($value['users_count'])
                {
                    $array_data['count_pro'] = $value['users_count'];
                }
            }

            $count_packages += $value['users_count'];

        }

        $array_data['total_count_company'] = $count_packages;

        return $array_data;

    }

    public function getPackageAndSetting() {

        $packages  =  $this->model->with('setting')->orderBy('fee','DESC')->get()->toArray();

        foreach ($packages as $key => $value) {
            $packages[$key]['setting_id'] = $value['setting']['id'];
            $packages[$key]['expiration_date'] = $value['setting']['expiration_date'];
            $packages[$key]['card_fee'] = $value['setting']['card_fee'];
            $packages[$key]['bonus'] = $value['setting']['bonus'];
            $packages[$key]['sms'] = $value['setting']['sms'];  
            $packages[$key]['email_service'] = $value['setting']['email_service'];  
            $packages[$key]['package_id'] = $value['setting']['package_id'];  
        }

        return $packages; 
    }


    public function updatePackageAndSetting($attributes){

        $packages = $this->model->where('id',$attributes['id'])->update([
                    'package_name'      => $attributes['package_name'],
                    'short_description' => $attributes['short_description'],
                    'full_description'  => isset($attributes['full_description']) ? $attributes['full_description'] : '',
                    'fee'               => $attributes['fee'],
                    'secure_storage'    => $attributes['secure_storage'],
                    'file_upload'       => $attributes['file_upload'],
                    'minimum_user'      => $attributes['minimum_user'],
                    'max_user'          => $attributes['max_user'] 
            ]);

        $setting = Setting::where('id',$attributes['setting_id'])->update([
                    'expiration_date'  => $attributes['expiration_date'],
                    'fee'              => $attributes['fee'],
                    'card_fee'         => $attributes['card_fee'],
                    'bonus'            => $attributes['bonus'],
                    'sms'              => $attributes['sms'],
                    'email_service'    => $attributes['email_service'],
                    'package_id'       => $attributes['package_id']
                ]);

        return $packages; 

    }

}
