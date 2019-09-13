<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CartRepository;
use App\Models\Cart;
use App\Validators\CartValidator;

/**
 * Class CartRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CartRepositoryEloquent extends BaseRepository implements CartRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Cart::class;
    }

    public function handleAddPhoto()
    {
        $photo = request('photo');

        $photoPackage = \App\Models\PhotoPackage::where('size', 'like', '%'.$photo['size'].'%')->first();

        $imageId = $photo['id'];
        
        if(isset($photo['image_id'])) {
            $imageId = $photo['image_id'];
        }

        $cart = $this->model->whereImageId($imageId)->first();

        if(!empty($cart)) {
            $cart = $this->model->whereId($cart->id)->update(array(
                'quantity' => $photo['quantity'], 
                'photo_package_id' => $photoPackage->id,
                'price' => $photoPackage->dollar * $photo['quantity']));
        } else {
            $cart = $this->model->create([
                'image_id' => $photo['id'], 
                'quantity' => $photo['quantity'], 
                'photo_package_id' => $photoPackage->id,
                'price' => $photoPackage->dollar * $photo['quantity'] 
            ]);
        }

        return $cart;
    }

    public function handleDeletePhoto()
    {
        if(!empty(request('imageId'))) {

            $cart = $this->model->whereImageId(request('imageId'))->delete();

            return true;
        }

    }

    // public function handleGetPhotoSelected()
    // {
    //     $listing = \App\Models\Listing::with(['images' => function($query) {
    //                     $query->with('imageSelected');
    //                 }])->whereRoomId(request('room'))->first()->toArray();

    //     $photos = [];

    //     if(count($listing['images']) > 0) {
            
    //         foreach($listing['images'] as $image) 
    //         {
    //             if($image['image_selected'] != null) {
                    
    //                 $photoPackge = \App\Models\PhotoPackage::find($image['image_selected']['photo_package_id']);
    //                 $image['image_selected']['size'] = $photoPackge->size; 
    //                 $image['image_selected']['name'] = $image['filename'];
    //                 $image['image_selected']['checked'] = true;
    //                 $photos[] = $image['image_selected'];   
    //             }   
    //         }
    //     }

    //     return $photos;  
    // }

    public function handleCustomerOrderImage()
    {
        $image = request('photo');

        $cart = $this->model->whereImageId($image['id'])->first();

        if(!empty($cart)) {
            $cart = $cart->delete();
        }else{
            $cart = $this->model->create([
                    'image_id' => $image['id'], 
                    'quantity' => 1, 
                    'photo_package_id' => 2,
                    'price' => 2
                ]);
        }

        return $cart;
    }

    public function handleGetPhotoSelectedNew()
    {
        $listing = \App\Models\Listing::with(['images' => function($query) {
                        $query->where('is_booking', '0')->where('img_type', 'COMPRESSED');
                        $query->with('imageSelected');
                    }])->whereRoomId(request('roomId'))->first()->toArray();
        
        $photos = [];

        if(count($listing['images']) > 0) {
            foreach($listing['images'] as $image) 
            {
                if($image['image_selected'] != null) {
                    $photoPackge = \App\Models\PhotoPackage::find($image['image_selected']['photo_package_id']);
                    $image['image_selected']['size'] = $photoPackge->size; 
                    $image['image_selected']['name'] = $image['filename'];
                    $image['image_selected']['checked'] = true;
                    $photos[] = $image['image_selected'];   
                }   
            }
        }

        $roomPhoto =  \App\Models\Room::find(request('roomId'));

        $dir = '/storage/images/'.$roomPhoto->room_hash.'/compressed/';

        return [$photos, $dir];  
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
