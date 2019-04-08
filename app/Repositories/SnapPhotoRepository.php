<?php

namespace App\Repositories;

use App\Models\SnapPhoto;
use App\Models\Room;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class Snap_PhotoRepository
 * @package App\Repositories
 * @version March 21, 2019, 3:30 am UTC
 *
 * @method Snap_Photo findWithoutFail($id, $columns = ['*'])
 * @method Snap_Photo find($id, $columns = ['*'])
 * @method Snap_Photo first($columns = ['*'])
*/
class SnapPhotoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'branch_id',
        'photographer_id',
        'room_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SnapPhoto::class;
    }

    public function handleCreateSnapPhoto()
    {   
        $roomHash = 'R'.mt_rand(500000, 1000000);

        $rooms = Room::all();

        $array = [] ;

        foreach($rooms as $index => $room) {
            $array[] = $room;

            if($room['room_hash'] == $roomHash)
            {
                $roomHash = 'R'.mt_rand(500000, 1000000);
                foreach($array as $value) 
                {
                    if($value['room_hash'] == $roomHash) {
                        $roomHash = 'R'.mt_rand(500000, 1000000);
                    }
                }
            }
        } 
            
        $room = Room::create(
                ['room_number' => request('room'),
                 'room_hash' => $roomHash
                ]);

        $snapPhoto = $this->model->create([
                                'branch_id' => request('branchId'),
                                'photographer_id' => request('photographerId'),
                                'room_id' => $room['id']
                    ]);

        return $snapPhoto;
    }

    public function handleFindRoom()
    {
        $room = Room::whereRoomNumber(request('room'))->orderBy('created_at', 'DESC')->first();

        if(!empty($room)) {
            $snapPhoto = $this->model->with('snapPhotoDetails')->whereRoomId($room['id'])->first();
            $snapPhoto['room_number'] = $room['room_number'];

            return $snapPhoto;
        }

        return false;
    }
}
