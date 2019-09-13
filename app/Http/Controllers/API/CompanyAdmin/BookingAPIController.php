<?php

namespace App\Http\Controllers\API\CompanyAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BookingRepository;
use App\Http\Controllers\AppBaseController;

class BookingAPIController extends AppBaseController
{
	protected $bookingRepo;

    public function __construct(BookingRepository $bookingRepo)
    {
        $this->bookingRepo = $bookingRepo;
    }

    public function getBookings()
    {
    	$bookings = $this->bookingRepo->handleGetBookings();

    	if(empty($bookings)) {
    		return $this->sendResponse($bookings, 'Booking with date not data');
    	}

    	if($bookings == false) {
    		return $this->sendError('Bookings data empty');
    	}

    	return $this->sendResponse($bookings, 'Booking retrieved successfully');
    }

    /**
     * [updateDateTime description]
     * request: date, time
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function updateDateTime($id)
    {
        $booking = $this->bookingRepo->findWithoutFail($id);

        if (empty($booking)) {
            return $this->sendError('Booking not found');
        }

        if(!empty(request('timezoneId'))) {

            $booking =  $this->bookingRepo->handleUpdateDateTime($booking);   
        } else {
            $input = request()->except('timezoneId');

            $booking = $this->bookingRepo->update($input, $id);
        }

        return $this->sendResponse($booking, 'Booking updated successfully');
    }

    public function convertTimezone()
    {
        $booking = $this->bookingRepo->handleConvertTimezone();

        if(empty($booking)) {
            return $this->sendError('Booking not found');
        }

        return $this->sendResponse($booking, 'Booking retrieved successfully');
    }

    public function destroy($id)
    {
        $booking = $this->bookingRepo->findWithoutFail($id);

        if (empty($booking)) {
            return $this->sendError('Booking not found');
        }

        $booking->delete();

        return $this->sendResponse($id, 'Booking deleted successfully');
    }

    public function sendMailCustomer($id)
    {
        $booking = $this->bookingRepo->handleSendEmailCustomer($id);

        if(!$booking) {
             return $this->sendError('Booking not found');
        }

        return $this->sendResponse($booking, 'Send email success');

    }
}
