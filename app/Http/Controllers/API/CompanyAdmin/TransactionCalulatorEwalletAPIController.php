<?php

namespace App\Http\Controllers\API\CompanyAdmin;

use App\Http\Requests\API\CreateTransactionCalulatorEwalletAPIRequest;
use App\Http\Requests\API\UpdateTransactionCalulatorEwalletAPIRequest;
use App\Models\TransactionCalulatorEwallet;
use App\Repositories\TransactionCalulatorEwalletRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Spatie\Activitylog\Models\Activity;
use App\Repositories\CompanyAdminRepositories\NotificationRepository;


/**
 * Class TransactionCalulatorEwalletController
 * @package App\Http\Controllers\API
 */

class TransactionCalulatorEwalletAPIController extends AppBaseController
{
    /** @var  TransactionCalulatorEwalletRepository */
    private $transactionCalulatorEwalletRepository;
    private $notificationRepository;
    const STATUS_DONE = 'DONE' ;

    public function __construct(TransactionCalulatorEwalletRepository $transactionCalulatorEwalletRepo, NotificationRepository $notificationRepo)
    {
        $this->transactionCalulatorEwalletRepository = $transactionCalulatorEwalletRepo;
        $this->notificationRepository = $notificationRepo;
    }

    /**
     * Display a listing of the TransactionCalulatorEwallet.
     * GET|HEAD /transactionCalulatorEwallets
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->transactionCalulatorEwalletRepository->pushCriteria(new RequestCriteria($request));
        $this->transactionCalulatorEwalletRepository->pushCriteria(new LimitOffsetCriteria($request));
        $transactionCalulatorEwallets = $this->transactionCalulatorEwalletRepository->all();

        return $this->sendResponse($transactionCalulatorEwallets->toArray(), 'Transaction Calulator Ewallets retrieved successfully');
    }

    /**
     * Store a newly created TransactionCalulatorEwallet in storage.
     * POST /transactionCalulatorEwallets
     *
     * @param CreateTransactionCalulatorEwalletAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTransactionCalulatorEwalletAPIRequest $request)
    {
        $input = $request->all();

        $transactionCalulatorEwallets = $this->transactionCalulatorEwalletRepository->create($input);

        return $this->sendResponse($transactionCalulatorEwallets->toArray(), 'Transaction Calulator Ewallet saved successfully');
    }

    /**
     * Display the specified TransactionCalulatorEwallet.
     * GET|HEAD /transactionCalulatorEwallets/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var TransactionCalulatorEwallet $transactionCalulatorEwallet */
        $transactionCalulatorEwallet = $this->transactionCalulatorEwalletRepository->findWithoutFail($id);

        if (empty($transactionCalulatorEwallet)) {
            return $this->sendError('Transaction Calulator Ewallet not found');
        }

        return $this->sendResponse($transactionCalulatorEwallet->toArray(), 'Transaction Calulator Ewallet retrieved successfully');
    }

    /**
     * Update the specified TransactionCalulatorEwallet in storage.
     * PUT/PATCH /transactionCalulatorEwallets/{id}
     *
     * @param  int $id
     * @param UpdateTransactionCalulatorEwalletAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTransactionCalulatorEwalletAPIRequest $request)
    {
        $input = $request->all();

        /** @var TransactionCalulatorEwallet $transactionCalulatorEwallet */
        $transactionCalulatorEwallet = $this->transactionCalulatorEwalletRepository->findWithoutFail($id);

        if (empty($transactionCalulatorEwallet)) {
            return $this->sendError('Transaction Calulator Ewallet not found');
        }

        $transactionCalulatorEwallet = $this->transactionCalulatorEwalletRepository->update($input, $id);

        return $this->sendResponse($transactionCalulatorEwallet->toArray(), 'TransactionCalulatorEwallet updated successfully');
    }

    /**
     * Remove the specified TransactionCalulatorEwallet from storage.
     * DELETE /transactionCalulatorEwallets/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var TransactionCalulatorEwallet $transactionCalulatorEwallet */
        $transactionCalulatorEwallet = $this->transactionCalulatorEwalletRepository->findWithoutFail($id);

        if (empty($transactionCalulatorEwallet)) {
            return $this->sendError('Transaction Calulator Ewallet not found');
        }

        $transactionCalulatorEwallet->delete();

        return $this->sendResponse($id, 'Transaction Calulator Ewallet deleted successfully');
    }

    /*
    *   Target : Get all transaction history belongs to company id
    *   GET /e-wallet/transaction-history
    *
    *   @param  Request
    *   return Json
    */
    public function getEWalletTransactionHistory(Request $request){

        $input = $request->all();

        $result = $this->transactionCalulatorEwalletRepository->eWalletTransactionHistory($input,self::STATUS_DONE);

        return $this->sendResponse($result, 'Transactions retrieved successfully');

    }

    public function calEwallet(Request $request){
        $input = $request->all();

        $results = $this->transactionCalulatorEwalletRepository->calculatorEwallet($input);
 
        if($results <= 0) {

            $this->notificationRepository->createNotifi($input['user_id'], 'AvailableBalanceIs0','Available balance is 0');
        }
        return $results;
    }


    
}
