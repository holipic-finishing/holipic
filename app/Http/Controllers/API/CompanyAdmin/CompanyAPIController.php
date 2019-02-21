<?php

namespace App\Http\Controllers\API\CompanyAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CompanyRepository;
use Response;
use App\Http\Controllers\AppBaseController;

class CompanyAPIController extends AppBaseController
{
	/** @var  CompanyRepository */
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepo)
    {
        $this->companyRepository = $companyRepo;
    }

    /*  Target : function export email information customer by company id
    *   GET company/export/customer
    *   
    */
    public function exportEmailCustomerByCompanyId(Request $request){

        $input = $request->all();
    
        $this->createLink($input['company_id']);

        $results = $this->companyRepository->handleExportCustomerByCompanyId($input['company_id']);

        return \Response::json([
            'status' => true,
            'link' => url('/files/'.$input['company_id'].'_Customer_email.csv')
        ]);
    }

    /**
     * get Customer Emails
     * @return [type] [description]
     */
    public function getCustomerEmails()
    {
        $customers = $this->companyRepository->getCustomerByCompanyId(request('company_id'));

        if(!empty($customers)) {
            return $this->sendResponse($customers, 'Get Customer success');
        }

        return $this->sendError('Not data customer email');
    }

    /**
     * Send Email Customers
     * @return Response
     */
    public function sendEmailCustomer()
    {
        $customers = $this->companyRepository->handleSendMailToCustomers();

        if(!$customers) {
            return $this->sendError('Error send mail');
        }

        return $this->sendResponse($customers, 'Success send mail');
    }
}
