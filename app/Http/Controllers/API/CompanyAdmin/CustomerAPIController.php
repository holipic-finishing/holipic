<?php

namespace App\Http\Controllers\API\CompanyAdmin;

use App\Http\Requests\API\CreateCustomerAPIRequest;
use App\Http\Requests\API\UpdateCustomerAPIRequest;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Maatwebsite\Excel\Excel;
use App\Exports\SalesBranchExport;

/**
 * Class CustomerController
 * @package App\Http\Controllers\API
 */

class CustomerAPIController extends AppBaseController
{
    /** @var  CustomerRepository */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepository = $customerRepo;
    }

    /**
     * Display a listing of the Customer.
     * GET|HEAD /customers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->customerRepository->pushCriteria(new RequestCriteria($request));
        $this->customerRepository->pushCriteria(new LimitOffsetCriteria($request));
        $customers = $this->customerRepository->all();

        return $this->sendResponse($customers->toArray(), 'Customers retrieved successfully');
    }

    /**
     * Store a newly created Customer in storage.
     * POST /customers
     *
     * @param CreateCustomerAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerAPIRequest $request)
    {
        $input = $request->all();

        $customers = $this->customerRepository->create($input);

        return $this->sendResponse($customers->toArray(), 'Customer saved successfully');
    }

    /**
     * Display the specified Customer.
     * GET|HEAD /customers/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Customer $customer */
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        return $this->sendResponse($customer->toArray(), 'Customer retrieved successfully');
    }

    /**
     * Update the specified Customer in storage.
     * PUT/PATCH /customers/{id}
     *
     * @param  int $id
     * @param UpdateCustomerAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerAPIRequest $request)
    {
        $input = $request->all();

        /** @var Customer $customer */
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        $customer = $this->customerRepository->update($input, $id);

        return $this->sendResponse($customer->toArray(), 'Customer updated successfully');
    }

    /**
     * Remove the specified Customer from storage.
     * DELETE /customers/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Customer $customer */
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        $customer->delete();

        return $this->sendResponse($id, 'Customer deleted successfully');
    }

    public function getCustomers()
    {
        $customers = $this->customerRepository->handelGetCustomers();

        if(!$customers) {
            return $this->sendError('Customer not found');
        }

        return $this->sendResponse($customers, 'Get customer successfully');
    }

    public function updateCustomer($id)
    {
       
        $customer = $this->customerRepository->handleUpdateCustomer($id);

        if(!$customer) {
            return $this->sendError('Error update customer');
        }

        return $this->sendResponse($customer, 'Update customer successfully');
    }

    public function exportEmailCustomers()
    {
        return \Excel::download(new SalesBranchExport(request('companyId')), 'ListEmailCustomers.xlsx');
    }
}
