<?php

namespace App\Http\Controllers\API\CompanyAdmin;

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
		$activityLogs = $this->activityLogRepository->handleShowActivityLog($request->all());

		$times = $this->activityLogRepository->groupTimeActivityLog();

        return $this->sendResponse([$activityLogs, $times], 'Get Active Log Successfully');

	}

	public function updateIsReadActivityLog(Request $request)
	{
		$activityLog = $this->activityLogRepository->handleUpdateIsRead($request['id']);

		if(!$activityLog) {
			return $this->sendError('Can not update activity log');
		}

		return $this->sendResponse($activityLog, 'Success update activity');
	}
}
