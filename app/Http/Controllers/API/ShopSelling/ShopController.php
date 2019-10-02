<?php

namespace App\Http\Controllers\API\ShopSelling;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ListingRepository;
use App\Repositories\RoomRepository;

class ShopController extends AppBaseController
{
    /**
     * @var ListingRepository
     */
    protected $listingRepo;

    /**
     * @var RoomRepository
     */
    protected $roomRepo;

    /**
     * ListingsController constructor.
     *
     * @param ListingRepository $repository
     */
    public function __construct(ListingRepository $listingRepo, RoomRepository $roomRepo)
    {
        $this->listingRepo = $listingRepo;
        $this->roomRepo = $roomRepo;
    }

    public function getRooms(Request $request)
    {
        $request = $request->all();
        $branch_id = $request['branch_id'];

        $listings = $this->listingRepo->with('room')->findByField('branch_id', $branch_id);
        if($listings) $rooms = $listings->pluck('room')->pluck('room_hash')->unique();

        return $this->sendResponse($rooms, 'Successfully!');
    }

    public function getPhotos(Request $request)
    {
        $request = $request->all();
        $room_hash = $request['room_hash'];
        $listings = $this->roomRepo->with(['listings' => function($listing){
            $listing->with(['images' => function($images){
                $images->where('img_type', 'COMPRESSED');
            }]);
        }])->findByField('room_hash', $room_hash)->pluck('listings')->first();

        $images = [];

        foreach($listings as $listing) {
            foreach($listing->images as $image) {
                $images[] = $image;
            }
        }

        return $this->sendResponse($images, 'Successfully!');
    }
}
