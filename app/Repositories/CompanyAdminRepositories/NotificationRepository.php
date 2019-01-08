<?php

namespace App\Repositories\CompanyAdminRepositories;

use App\Models\CompanyAdmin\Notification;
use InfyOm\Generator\Common\BaseRepository;
use DB;
use App\Events\RedisEventNotification;

/**
 * Class NotificationRepository
 * @package App\Repositories
 * @version December 25, 2018, 2:25 am UTC
 *
 * @method Notification findWithoutFail($id, $columns = ['*'])
 * @method Notification find($id, $columns = ['*'])
 * @method Notification first($columns = ['*'])
*/
class NotificationRepository extends BaseRepository
{
    /**
     * @var array
     */

    const IS_READ = 1 ;             // The status has read
    const NOT_IS_READ = 0 ;         // The status not read

    protected $fieldSearchable = [
        'user_id',
        'message'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Notification::class;
    }

    public function createNotifi($user_id,$message) {

        $Notification = $this->model->create([
                            'user_id' => $user_id,
                            'message' => 'message.'.$message
                        ]);

        $this->evenNotification($Notification);
    }

     /**
    * Target: Get data in table Notification where by is_read, user_id, $limit
    * @params:  $is_read, $user_id, $limit
    * @return : json
    **/
    public function getNotificationByIsRead($is_read,$user_id,$limit){

        if($limit == null) {
            $results = $this->model->where('is_read',$is_read)
                                ->where('user_id',$user_id)
                                ->orderBy('created_at', 'desc')
                                ->get();
        } else {
            
            $results = $this->model->where('is_read',$is_read)
                                ->where('user_id',$user_id)
                                ->orderBy('created_at', 'desc')
                                ->limit($limit)
                                ->get();
        }

        return $results;

    }

    /**
    * Target: Get all data in table Notification where by user_id
    * @params:  $user_id
    * @return : json
    **/
    public function showNotificationByUserId($user_id){
        return $this->model->where('user_id',$user_id)->get();
    }


    /**
    * Target: Get all data in table Notification where by user_id and paginate
    * @params: $perPage , $user_id
    * @return : collection
    **/
    public function getNotificationByUserId($perPage,$user_id){
        
        $results = $this->model->where('user_id',$user_id)->orderBy('created_at', 'desc');

        return $results->paginate($perPage);
    }

    /**
    * Target: Event for Notification
    * from: func:createNotifi
    * to: $attribute
    **/
    public function evenNotification($attribute) {
        event(
            $e = new RedisEventNotification($attribute)
        );
    }
}
