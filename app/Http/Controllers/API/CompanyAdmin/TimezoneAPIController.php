<?php

namespace App\Http\Controllers\API\CompanyAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\TimezoneRepository;
use Carbon\Carbon;

class TimezoneAPIController extends AppBaseController
{
    protected $timezoneRepo;

    public function __construct(TimezoneRepository $timezoneRepo)
    {
        $this->timezoneRepo = $timezoneRepo;
    }

    public function getTimezones()
    {
    	$timezones = $this->timezoneRepo->handleGetTimezones();

        // $timezones = $this->timezoneRepo->all();

    	if(!empty($timezones)) {
    		return $this->sendResponse($timezones, 'Timezone retrieved successfully');
    	}

    	return $this->sendError('Timezone not found');
    }
}
