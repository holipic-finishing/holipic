<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Repositories\ActivityLogRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\User;
use Auth;
use Spatie\Activitylog\Models\Activity;



class ActivityLogController extends AppBaseController
{
	private $activityLogRepository;

	public function __construct(ActivityLogRepository $activityLogRepository)
	{
		$this->activityLogRepository = $activityLogRepository;
	}

	public function getActivityLog(Request $request)
	{
		$activityLog = $this->activityLogRepository->handleShowActivityLog($request->all());

		$times = $this->activityLogRepository->groupTimeActivityLog();

        return $this->sendResponse([$activityLog, $times], 'Get Active Log Successfully');

	}   
}
