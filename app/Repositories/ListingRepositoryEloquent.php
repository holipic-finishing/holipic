<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ListingRepository;
use App\Models\Listing;
use App\Validators\ListingValidator;

/**
 * Class ListingRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ListingRepositoryEloquent extends BaseRepository implements ListingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Listing::class;
    }

    public function handleLoginRoom()
    {
        $room = \App\Models\Room::whereRoomNumber(request('room'))->latest()->first();

        if(!empty($room)) {
            return $room;
        }

        return false;
    }

    /**
     * [handleGetPhotos description]
     * @return [type] [description]
     */
    public function handleGetPhotos()
    {
        try {
            $roomPhoto = $this->model->with(['images.imageSelected','room'])->whereRoomId(request('room'))->first()->toArray();

            if(!empty($roomPhoto)) {

                $array = [];

                foreach($roomPhoto['images'] as $value)
                {
                    if($value['img_type'] == "COMPRESSED") {
                        $value['checked'] = false;

                        $value['name'] = $value['filename'];

                        if($value['image_selected'] != null) {

                            $value['checked'] = true;

                            $value['image_selected']['name'] = $value['filename'];

                            $photoPackage = \App\Models\PhotoPackage::find($value['image_selected']['photo_package_id']);

                            $value['image_selected']['size'] = $photoPackage->size;
                        }

                        $array[] = $value;
                    }
                }
                
                $dir = '/storage/images/'.$roomPhoto['room']['room_hash'].'/compressed/';

                $roomPhoto['images'] = $array;

                return [$roomPhoto, $dir];
            }
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
