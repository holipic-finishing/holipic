<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Repositories\ActiveLogRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\User;
use Auth;
use Spatie\Activitylog\Models\Activity;



class ActiveLogController extends AppBaseController
{
	private $activeLogRepository;

	public function __construct(ActiveLogRepository $activeLogRepository)
	{
		$this->activeLogRepository = $activeLogRepository;
	}

	public function getActiveLog(Request $request)
	{
		$activeLog = $this->activeLogRepository->handleShowActiveLog($request->all());

		$times = $this->activeLogRepository->groupTimeActivityLog($request->all());

        return $this->sendResponse([$activeLog, $times], 'Get Active Log Successfully');

	}   
}
