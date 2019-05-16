<?php

namespace App\Http\Controllers\API\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CartRepository;
use App\Http\Controllers\AppBaseController;


class CustomerAPIController extends AppBaseController
{
    protected $customerRepository;

    protected $cartRepository;

    public function __construct(CartRepository $cartRepository) 
    {
    	$this->cartRepository = $cartRepository;
    }

    /**
     * [orderImage description]
     * @return [cart] [description]
     */
    public function orderImage()
    {
    	$cart = $this->cartRepository->handleCustomerOrderImage();

        return $this->sendResponse($cart, 'Add cart success'); 

    }

    public function getImageSelected()
    {
    	$cart = $this->cartRepository->handleGetPhotoSelectedNew();

    	return $this->sendResponse($cart, 'Get image selected success');
    }
}
