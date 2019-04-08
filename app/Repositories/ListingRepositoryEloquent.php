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

    /**
     * [handleGetPhotos description]
     * @return [type] [description]
     */
    public function handleGetPhotos()
    {
        $room = \App\Models\Room::whereRoomNumber(request('room'))->latest()->first();

        if(!empty($room)) {
            $roomPhoto = $this->model->with('images')->whereRoomId($room['id'])->first();
    
            return $roomPhoto;
        }

        return false;

    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
