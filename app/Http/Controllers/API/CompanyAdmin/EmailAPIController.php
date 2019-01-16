<?php

namespace App\Http\Controllers\API\CompanyAdmin;

use App\Http\Requests\API\CreateEmailAPIRequest;
use App\Http\Requests\API\UpdateEmailAPIRequest;
use App\Models\CompanyAdmin\Email;
use App\Repositories\CompanyAdminRepositories\EmailRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class EmailController
 * @package App\Http\Controllers\API
 */

class EmailAPIController extends AppBaseController
{
    /** @var  EmailRepository */
    private $emailRepository;

    public function __construct(EmailRepository $emailRepo)
    {
        $this->emailRepository = $emailRepo;
    }

    /**
     * Display a listing of the Email.
     * GET|HEAD /emails
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->emailRepository->pushCriteria(new RequestCriteria($request));
        $this->emailRepository->pushCriteria(new LimitOffsetCriteria($request));
        $emails = $this->emailRepository->all();

        return $this->sendResponse($emails->toArray(), 'Emails retrieved successfully');
    }

    /**
     * Store a newly created Email in storage.
     * POST /emails
     *
     * @param CreateEmailAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateEmailAPIRequest $request)
    {
        $input = $request->all();
 
        $emails = $this->emailRepository->create($input);

        return $this->sendResponse($emails->toArray(), 'Email saved successfully');
    }

    /**
     * Display the specified Email.
     * GET|HEAD /emails/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Email $email */
        $email = $this->emailRepository->findWithoutFail($id);

        if (empty($email)) {
            return $this->sendError('Email not found');
        }

        return $this->sendResponse($email->toArray(), 'Email retrieved successfully');
    }

    /**
     * Update the specified Email in storage.
     * PUT/PATCH /emails/{id}
     *
     * @param  int $id
     * @param UpdateEmailAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEmailAPIRequest $request)
    {
        $input = $request->all();

        /** @var Email $email */
        $email = $this->emailRepository->findWithoutFail($id);

        if (empty($email)) {
            return $this->sendError('Email not found');
        }

        $email = $this->emailRepository->update($input, $id);

        return $this->sendResponse($email->toArray(), 'Email updated successfully');
    }

    /**
     * Remove the specified Email from storage.
     * DELETE /emails/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Email $email */
        $email = $this->emailRepository->findWithoutFail($id);

        if (empty($email)) {
            return $this->sendError('Email not found');
        }

        $email->delete();

        return $this->sendResponse($id, 'Email deleted successfully');
    }

    /* Target : Function update email by cloumn
    *  POST edit/email/{itemId}
    *  
    */
    public function editEmail(Request $request, $itemId){
        $input =  $request->all();

        if (!$input['value']) {
            return $this->sendError('This field could be not null');
        }

        $result = null;

        if ($input['field_name'] == 'email_title') {

            $page = $this->emailRepository->find($itemId);

            if(empty($page)){
                return $this->sendError('Email not found');
            }

            $result = $this->emailRepository->find($itemId)->update([
                        'email_title' => $input['value']
                    ]);
        }

        if ($input['field_name'] == 'email_content') {

            $page = $this->emailRepository->find($itemId);

            if(empty($page)){
                return $this->sendError('Email not found');
            }

            $result = $this->emailRepository->find($itemId)->update([
                        'email_content' => $input['value'],
                        'format_email_content' => $input['sort_value']
                    ]);
        }

        if($result){

            return $this->sendResponse([], 'Email updated successfully');
        }else{

            return $this->sendError('System Error Occurred');
        }
    }
}

