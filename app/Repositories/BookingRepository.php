<?php

namespace App\Repositories;

use InfyOm\Generator\Common\BaseRepository;
use App\Models\Booking;
use Carbon\Carbon;
use App\Models\Timezone;
use Mail;

use App\Mail\SendMailBooking;
/**
 *  Class BookingRepository
 *  @package App\Repositories
 *  
 */
class BookingRepository extends BaseRepository
{
	/**
     * Configure the Model
     **/
    public function model()
    {
        return Booking::class;
    }

    /**
     * [handleGetBookings description]
     * request: companyId, date
     * @return [type] [description]
     */
    public function handleGetBookings($convertedDate = null,$defaultTimezone = null)
    {
        $companyId = request('companyId');

        $date = request('date');

        $timezoneId = request('timezone');

        if(!empty($timezoneId)) {
        	$timezone = Timezone::find($timezoneId);

        	$valueDate =  Carbon::parse($date);

			$valueDate = Carbon::createFromFormat('Y-m-d H:i:s', $valueDate, $timezone['zone_name']);

			$date = $valueDate->setTimeZone('UTC');

			$date = $date->toDateString();

        }

        if(!empty($date)) {
        	$valueDate = Carbon::parse(str_replace('+', ' ', $date));

			$date = substr($valueDate, 0, 10);
        }

    	if(!empty($companyId)) {
    		$bookings = $this->scopeQuery(function($query) use ($companyId, $date, $convertedDate){

			            $query = $query->with(['photographer' => function($q) use ($companyId) {
			                        $q->with(['branch' => function($q2) use ($companyId) {
			                        	$q2->whereCompanyId($companyId);
			                        }]);
			                     }]);

			            $query = $query->with('customer.room');

			            // if(!empty($date)) {
			            // 	$query = $query->whereDate('date', Carbon::parse($date)->toDateString());
			            // }

			            //If client change timezone
			            // if(!empty($convertedDate)) {
			            	
			            // 	$query = $query->whereDate('date', $convertedDate);
			            // }																

			            return $query;
			})->get();

			if(!empty($bookings)) {

				$timezone = [];
				if(!empty($timezoneId) || $defaultTimezone != null) {
                    $timezoneId = (!empty($timezoneId)) ? $timezoneId : $defaultTimezone;
					$timezone = Timezone::find($timezoneId);
				}

				if($convertedDate != null) {

					$bookings = $this->handleRequestTimezone($timezone[0], $bookings, $convertedDate);
                    
				} else {
					
					$bookings = $this->handleRequestTimezone($timezone, $bookings, $date);
				}
				
				return $this->handleCutTime($bookings);
    		}		
		}

		return false;
	}

    public function handleRequestTimezone($timezone, $bookings, $date)
    {
    	$data = [];
    	
    	$newArray = [];

    	if(empty($timezone)) {
    		foreach($bookings as $booking)
    		{
    			if(trim($booking['date']) == trim($date)) {
    				$newArray[] = $booking;
    			}	
    		}
    	} else {

	    	foreach($bookings as $index => $booking) 
			{
				$utcDate = Carbon::parse($booking['date'].' '.$booking['time']);

				$convertedDate = $utcDate->setTimeZone($timezone['zone_name']);

				$booking['date'] = $convertedDate->toDateString();

				$utcTime = Carbon::parse($booking['time']);

				$convertedTime = $utcTime->setTimeZone($timezone['zone_name']);

				$booking['time'] = $convertedTime->toTimeString();

				$data[] = $booking;

			}

			foreach($data as $value) 
			{
				if($value['date'] == $date) {
					$newArray[] = $value;
				}
			}
    	}


		return $newArray;
    }

    public function handleCutTime($data) 
    {
    	$array = [];

		foreach($data as $value) 
		{
			$value['time'] = substr($value['time'], 0, 5);

			$array[] = $value;
		}

		return $array;
    }

    public function handleConvertTimezone()
    {
        if(!empty(request('timezoneId'))) {

        	$timezone = Timezone::find(request('timezoneId'));

        	$date = Carbon::parse(str_replace('T', ' ', request('datetime')));

        	$convertedDate = $date->setTimeZone($timezone['zone_name'])->toDateString();

        	$data = [];

        	$bookings = $this->handleGetBookings($convertedDate, $timezone);

        	if(!empty($timezone)) {
        		$data = $this->handleRequestTimezone($timezone, $bookings, $convertedDate);
    	
        	} else {
        		$data = $bookings;
        	}

        	return $this->handleCutTime($data);
        }

        return false;
    }

    public function handleUpdateDateTime($booking)
    {
    	$timezoneId = request('timezoneId');

    	$date = request('date');

    	$time = request('time');

    	if(!empty($timezoneId)){
    		$timezone = Timezone::find($timezoneId);

    		if($timezone && $time){
    			$valueTime =  Carbon::parse($booking['date'].' '.$time);
    			$time = Carbon::createFromFormat('Y-m-d H:i:s', $valueTime, $timezone['zone_name']);
    			$utc = $time->setTimeZone('UTC');
				$utc = $utc->toTimeString();
				$input = ['time' => $utc];
    		}

    		if($timezone && $date) {
    			$valueDate =  Carbon::parse($date.' '.$booking['time']);
    			$date = Carbon::createFromFormat('Y-m-d H:i:s', $valueDate, $timezone['zone_name']);
				$utc = $date->setTimeZone('UTC');
				$utc = $utc->toDateString();
				$input = ['date' => $utc];
    		}

    		$booking = $this->model->whereId($booking['id'])->update($input);

    		return $booking;
    	}

    	return false;
    }

    public function handleSendEmailCustomer($bookingId)
    {

        if(!empty($bookingId)) {

            $booking = $this->scopeQuery(function($query) use ($bookingId){
                            $query = $query->with('photographer')->with('customer.user')->whereId($bookingId);
                            return $query;
                        })->first();

            \Mail::to($booking['customer']['user']['email'])->queue(new SendMailBooking($booking));

            return $booking;
            
        }

        return false;
    }

}