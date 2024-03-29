<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Requests\API\CreateCompanyAPIRequest;
use App\Http\Requests\API\UpdateCompanyAPIRequest;
use App\Models\Company;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Maatwebsite\Excel\Excel;
use App\Exports\ListCompaniesExport;

/**
 * Class CompanyController
 * @package App\Http\Controllers\API
 */

class CompanyAPIController extends AppBaseController
{
    /** @var  CompanyRepository */
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepo)
    {
        $this->companyRepository = $companyRepo;
    }

    /**
     * Display a listing of the Company.
     * GET|HEAD /companies
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->companyRepository->pushCriteria(new RequestCriteria($request));
        $this->companyRepository->pushCriteria(new LimitOffsetCriteria($request));

        $companies = $this->companyRepository->getCompanies(); 

        return $this->sendResponse($companies->toArray(), 'Companies retrieved successfully');
    }

    /**
     * Store a newly created Company in storage.
     * POST /companies
     *
     * @param CreateCompanyAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCompanyAPIRequest $request)
    {
        $input = $request->all();

        $companies = $this->companyRepository->create($input);

        return $this->sendResponse($companies->toArray(), 'Company saved successfully');
    }

    /**
     * Display the specified Company.
     * GET|HEAD /companies/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Company $company */
        
        $company = $this->companyRepository->findWithoutFail($id);
        if (empty($company)) {
            return $this->sendError('Company not found');
        }

        return $this->sendResponse($company->toArray(), 'Company retrieved successfully');
    }

    /**
     * Update the specified Company in storage.
     * PUT/PATCH /companies/{id}
     *
     * @param  int $id
     * @param UpdateCompanyAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompanyAPIRequest $request)
    {
        $input = $request->all();

        /** @var Company $company */
        $company = $this->companyRepository->findWithoutFail($id);

        if (empty($company)) {
            return $this->sendError('Company not found');
        }

        $company = $this->companyRepository->update($input['params'], $id);

        return $this->sendResponse($company->toArray(), 'Company updated successfully');
    }

    /**
     * Remove the specified Company from storage.
     * DELETE /companies/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Company $company */
        $company = $this->companyRepository->findWithoutFail($id);

        if (empty($company)) {
            return $this->sendError('Company not found');
        }

        $company->delete();

        return $this->sendResponse($id, 'Company deleted successfully');
    }

    public function getTransactionHistory(Request $request){
        
        $input = $request->all();

        return $this->sendResponse($results->toArray(), 'Transaction History successfully');
    }
    
    public function exportExcel(Request $request){

        return \Excel::download(new ListCompaniesExport($request->all()), 'ListCompany.xlsx');

    }

    public function showInformationCompany(Request $request) 
    {
        $companyInfo = $this->companyRepository->handleShowInformationCompany(request('companyId'));

        return $this->sendResponse($companyInfo, 'Get Information Company Completed');
    }

    /**
     * Target : Create file CSV customer HEADER
     * @From : func: exportEmailCustomerByCompanyId
     *
     */
    public function createLink($company_id){

        $path = public_path() . '/files' . DIRECTORY_SEPARATOR;
        
        $csvPath = $path .$company_id. '_Customer_email.csv';

        if(\File::exists($csvPath)){
            unlink($csvPath);
        }
        if(!\File::exists($path)) {
            \File::makeDirectory($path, $mode = 0777, true, true);
        }

        $file = fopen($csvPath,"a+");
        $keys = ['SN.','Email'];
        fputcsv($file,$keys);
        fclose($file); 
        return $csvPath;
    }
}
