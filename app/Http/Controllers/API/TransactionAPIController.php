<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTransactionAPIRequest;
use App\Http\Requests\API\UpdateTransactionAPIRequest;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class TransactionController
 * @package App\Http\Controllers\API
 */

class TransactionAPIController extends AppBaseController
{
    /** @var  TransactionRepository */
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactionRepository = $transactionRepo;
    }

    /**
     * Display a listing of the Transaction.
     * GET|HEAD /transactions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->transactionRepository->pushCriteria(new RequestCriteria($request));
        $this->transactionRepository->pushCriteria(new LimitOffsetCriteria($request));
        $transactions = $this->transactionRepository->all();

        return $this->sendResponse($transactions->toArray(), 'Transactions retrieved successfully');
    }

    /**
     * Store a newly created Transaction in storage.
     * POST /transactions
     *
     * @param CreateTransactionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTransactionAPIRequest $request)
    {
        $input = $request->all();

        $transactions = $this->transactionRepository->create($input);

        return $this->sendResponse($transactions->toArray(), 'Transaction saved successfully');
    }

    /**
     * Display the specified Transaction.
     * GET|HEAD /transactions/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Transaction $transaction */
        $transaction = $this->transactionRepository->findWithoutFail($id);

        if (empty($transaction)) {
            return $this->sendError('Transaction not found');
        }

        return $this->sendResponse($transaction->toArray(), 'Transaction retrieved successfully');
    }

    /**
     * Update the specified Transaction in storage.
     * PUT/PATCH /transactions/{id}
     *
     * @param  int $id
     * @param UpdateTransactionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTransactionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Transaction $transaction */
        $transaction = $this->transactionRepository->findWithoutFail($id);

        if (empty($transaction)) {
            return $this->sendError('Transaction not found');
        }

        $transaction = $this->transactionRepository->update($input, $id);

        return $this->sendResponse($transaction->toArray(), 'Transaction updated successfully');
    }

    /**
     * Remove the specified Transaction from storage.
     * DELETE /transactions/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Transaction $transaction */
        $transaction = $this->transactionRepository->findWithoutFail($id);

        if (empty($transaction)) {
            return $this->sendError('Transaction not found');
        }

        $transaction->delete();

        return $this->sendResponse($id, 'Transaction deleted successfully');
    }

    public function getInformationCompany()
    {
        $company = $this->transactionRepository->getInformationCompanyAndTotalAmountDefault(request('companyId'));
        return $this->sendResponse($company, 'Transaction Company successfully');
    }

    public function loadChartCompanyByTime(Request $request) 
    {

        $company = $this->transactionRepository->getInformationCompanyAndTotalAmountByTime($request->all());

        return $this->sendResponse($company, 'Transaction Company date/month successfully');

    }

    public function getHistories(Request $request){
        $params = $request->all();

        $transactions = $this->transactionRepository->getHistoriesTransaction($params);

        if ($transactions) {
            return $this->sendResponse($transactions->toArray(), 'Transactions retrieved successfully');
        }else{
            return $this->sendError('Data not found');
        }

    }

    public function doSearch(Request $request){
        $input = $request->all();

        $results =  $this->transactionRepository->search($input);

        return $this->sendResponse($results->toArray(), 'Transactions retrieved successfully');

    }

    public function editTransaction(Request $request, $itemId){

        $input =  $request->all();

        if ($input['status'] === "BEEN SEEN") {
            $input['status'] = "BEEN_SEEN";
        }

        $results = $this->transactionRepository->update($input, $itemId);

        if($results){

            return $this->sendResponse($results->toArray(), 'Transaction updated successfully');
        }else{
            return $this->sendError('System Error Occurred');
        }

    }

    public function doSearchDashboard(Request $request){
        $input = $request->all();

        $results =  $this->transactionRepository->searchDashboard($input);

        return $this->sendResponse($results->toArray(), 'Transactions retrieved successfully');
    }

    public function getTransactionHistory(Request $request) {

        $input = $request->all(); 

        $perPage = $request->input('perPage');

        $timeArr = ['Day', 'Week', 'Month', 'Year'];
        
        $data = [];

        foreach ($timeArr as $tmp) {
            $input['time'] = $tmp;
            $result = $this->transactionRepository->transactionHistory($input,$perPage);
            $data[$tmp] = $result; 
        }

        return $this->sendResponse($data, 'Transaction updated successfully');
    
    }

    public function getTransactionHistoryWithTimevalue(Request $request)
    {
        $input = $request->all();
        
        $result = $this->transactionRepository->transactionHistory($input, $input['perPage']);

        return $this->sendResponse($result, 'Transactions retrieved successfully');
    }

    public function showTotalCompanies(Request $request)
    {   
        $totalCompanies = $this->transactionRepository->handleShowTotalCompanies($request->all());

        return $this->sendResponse($totalCompanies, 'Get Transaction Total Companies with '.$request['choose'].' completed');
    }

}

