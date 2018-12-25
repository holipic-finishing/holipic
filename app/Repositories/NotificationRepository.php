<?php

namespace App\Repositories;

use App\Models\Notification;
use InfyOm\Generator\Common\BaseRepository;
use DB;

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
        return $this->model->create([
                        'user_id' => $user_id,
                        'message' => 'message.'.$message
                     ]);
    }

    public function getNotificationByIsRead($is_read,$user_id,$limit){

        if($limit == null) {
            $results = $this->model->select(DB::raw('COUNT(*) AS count'))
                                ->where('is_read',$is_read)
                                ->where('user_id',$user_id)
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

    public function showNotificationByUserId($user_id){
        return $this->model->where('user_id',$user_id)->get();
    }

    public function getNotificationByUserId($perPage,$user_id){
        
        $results = $this->model->where('user_id',$user_id);

        return $results->paginate($perPage);
    }
}
