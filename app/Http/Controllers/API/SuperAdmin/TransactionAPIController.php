<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Requests\API\CreateTransactionAPIRequest;
use App\Http\Requests\API\UpdateTransactionAPIRequest;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Spatie\Activitylog\Models\Activity;
use App\Repositories\CompanyAdminRepositories\NotificationRepository;

/**
 * Class TransactionController
 * @package App\Http\Controllers\API
 */

class TransactionAPIController extends AppBaseController
{
    /** @var  TransactionRepository */
    private $transactionRepository;
    private $notificationRepository;

    public function __construct(TransactionRepository $transactionRepo, NotificationRepository $notificationRepo)
    {
        $this->transactionRepository = $transactionRepo;
        $this->notificationRepository = $notificationRepo;
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

    public function getDashboardTransactions(Request $request){
        $params = $request->all();

        $transactions = $this->transactionRepository->getHistoriesTransaction($params);

        if ($transactions) {
            return $this->sendResponse($transactions->toArray(), 'Transactions retrieved successfully');
        }else{
            return $this->sendError('Data not found');
        }

    }

    public function editTransaction(Request $request, $itemId){

        $input =  $request->all();

        if (!$input['value']) {
            return $this->sendError('This field could be not null');
        }

        $result = null;

        if ($input['field_name'] == 'company_name') {
            $transaction = $this->transactionRepository->find($itemId);
            $user = $transaction->user()->first();
            $company = $user->company()->first();
            $result = app(\App\Repositories\CompanyRepository::class)->update([
                'name' => $input['value']
            ], $company->id);
        }

        $result = $this->transactionRepository->update([
            $input['field_name'] => $input['value']
        ], $itemId);

        // Save activity log
        // $log = Activity::all()->last();
        // $log['user_id'] = $input['userId'];
        // $log->save();

        if($result){

            return $this->sendResponse([], 'Transaction updated successfully');
        }else{
            return $this->sendError('System Error Occurred');
        }

    }


    /*
    *   Target : Search tranctions history by time value
    *   GET /transaction/history
    *
    *   @param  Request
    *   return Json
    */
    public function getCompanyTransactions(Request $request) {

        $input = $request->all(); 

        $perPage = $request->input('perPage');

        $timeArr = ['Day', 'Week', 'Month', 'Year'];
        
        $data = [];

        $searchBy = [];

        if($request->has('search') && $request->input('search')){

            $searchValues = explode(';', $request->input('search'));
            
            foreach ($searchValues as $val) {
            $tmp = explode(':', $val);

                if(count($tmp) > 1){
                    $searchBy[$tmp[0]] = $tmp[1];
                }
            }

        }
  
        foreach ($timeArr as $tmp) {
            $input['time'] = $tmp;
            $result = $this->transactionRepository->transactionHistory($input,$perPage, $searchBy);
            $data[$tmp] = $result; 
        }

        return $this->sendResponse($data, 'Transaction updated successfully');
    
    }


    /*
    *   Target : Search tranctions history by time and where by like title
    *   GET /transaction/history/item
    *
    *   @param  Request
    *   return Json
    */
    public function getTransactionHistoryWithTimeValue(Request $request)
    {
        $input = $request->all();

        $searchBy = [];

        if($request->has('search') && $request->input('search')){

            $searchValues = explode(';', $request->input('search'));
            
            foreach ($searchValues as $val) {
            $tmp = explode(':', $val);
    
                if(count($tmp) > 1){
                    $searchBy[$tmp[0]] = $tmp[1];
                }
            }
     
        }

        $result = $this->transactionRepository->transactionHistory($input, $input['perPage'], $searchBy);

        return $this->sendResponse($result, 'Transactions retrieved successfully');
    }
}

