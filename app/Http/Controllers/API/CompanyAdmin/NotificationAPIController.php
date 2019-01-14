<?php

namespace App\Http\Controllers\API\CompanyAdmin;

use App\Http\Requests\API\CreateNotificationAPIRequest;
use App\Http\Requests\API\UpdateNotificationAPIRequest;
use App\Models\CompanyAdmin\Notification;
use App\Repositories\CompanyAdminRepositories\NotificationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Events\RedisEventDeleteNotification;

/**
 * Class NotificationController
 * @package App\Http\Controllers\API\CompanyAdmin
 */

class NotificationAPIController extends AppBaseController
{
    /** @var  NotificationRepository */
    private $notificationRepository;

    const IS_READ = 1 ;             // The status has read
    const NOT_IS_READ = 0 ;         // The status not read

    public function __construct(NotificationRepository $notificationRepo)
    {
        $this->notificationRepository = $notificationRepo;
    }

    /**
     * Display a listing of the Notification.
     * GET|HEAD /notifications
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $this->notificationRepository->pushCriteria(new RequestCriteria($request));
        $this->notificationRepository->pushCriteria(new LimitOffsetCriteria($request));

        $perPage = $request->input('perPage', 6);

        $notifications = $this->notificationRepository->getNotificationByIsRead(self::NOT_IS_READ,$input['user_id'],$perPage);

        return $this->sendResponse($notifications->toArray(), 'Notifications retrieved successfully');
    }

    /**
     * Store a newly created Notification in storage.
     * POST /notifications
     *
     * @param CreateNotificationAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateNotificationAPIRequest $request)
    {
        $input = $request->all();

        $notifications = $this->notificationRepository->create($input);

        return $this->sendResponse($notifications->toArray(), 'Notification saved successfully');
    }


    /**
     * Display the specified Notification.
     * GET|HEAD /notifications/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {

        /** @var Notification $notification */
        $notification = $this->notificationRepository->showNotificationByUserId($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        return $this->sendResponse($notification->toArray(), 'Notification retrieved successfully');
    }


    /**
     * Update the specified Notification in storage.
     * PUT/PATCH /notifications/{id}
     *
     * @param  int $id
     * @param UpdateNotificationAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNotificationAPIRequest $request)
    {
        $input = $request->all();
        /** @var Notification $notification */
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }
        
        $data = [
            "is_read" => true
        ];
          
        $notification = $this->notificationRepository->update($data, $id);

        return $this->sendResponse($notification->toArray(), 'Notification updated successfully');
    }

    /**
     * Remove the specified Notification from storage.
     * DELETE /notifications/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Notification $notification */
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        $notification->delete();

        return $this->sendResponse($id, 'Notification deleted successfully');
    }


    /*
    *  Targer  : Function get data Notification with params and paginate
    *  GET /notifications
    *  @params : Request
    *  @return : Response 
    */ 
    public function getNotificationWithParams(Request $request){

        $perPage = $request->input('perPage', 6);

        $notifications = $this->notificationRepository->getNotificationByUserId($perPage,$request['user_id']);

        return $this->sendResponse($notifications->toArray(), 'Notifications retrieved successfully');
    
    }

    /* 
    *  Target : Function get all Notification 
    *  GET /get-notifications/{user_id}
    *   
    */

    public function getNotification($user_id){

        $resulfs = Notification::where('user_id',$user_id)->where('is_read','0')->get();

        return $this->sendResponse($resulfs->toArray(), 'Notifications retrieved successfully');

    }
}
