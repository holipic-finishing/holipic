<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateExchangeRateAPIRequest;
use App\Http\Requests\API\UpdateExchangeRateAPIRequest;
use App\Models\ExchangeRate;
use App\Repositories\ExchangeRateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ExchangeRateController
 * @package App\Http\Controllers\API
 */

class ExchangeRateAPIController extends AppBaseController
{
    /** @var  ExchangeRateRepository */
    private $exchangeRateRepository;

    public function __construct(ExchangeRateRepository $exchangeRateRepo)
    {
        $this->exchangeRateRepository = $exchangeRateRepo;
    }

    /**
     * Display a listing of the ExchangeRate.
     * GET|HEAD /exchangeRates
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->exchangeRateRepository->pushCriteria(new RequestCriteria($request));
        $this->exchangeRateRepository->pushCriteria(new LimitOffsetCriteria($request));
        $exchangeRates = $this->exchangeRateRepository->all();

        return $this->sendResponse($exchangeRates->toArray(), 'Exchange Rates retrieved successfully');
    }

    /**
     * Store a newly created ExchangeRate in storage.
     * POST /exchangeRates
     *
     * @param CreateExchangeRateAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateExchangeRateAPIRequest $request)
    {
        $input = $request->all();

        $exchangeRates = $this->exchangeRateRepository->create($input);

        return $this->sendResponse($exchangeRates->toArray(), 'Exchange Rate saved successfully');
    }

    /**
     * Display the specified ExchangeRate.
     * GET|HEAD /exchangeRates/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ExchangeRate $exchangeRate */
        $exchangeRate = $this->exchangeRateRepository->findWithoutFail($id);

        if (empty($exchangeRate)) {
            return $this->sendError('Exchange Rate not found');
        }

        return $this->sendResponse($exchangeRate->toArray(), 'Exchange Rate retrieved successfully');
    }

    /**
     * Update the specified ExchangeRate in storage.
     * PUT/PATCH /exchangeRates/{id}
     *
     * @param  int $id
     * @param UpdateExchangeRateAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExchangeRateAPIRequest $request)
    {
        $input = $request->all();

        /** @var ExchangeRate $exchangeRate */
        $exchangeRate = $this->exchangeRateRepository->findWithoutFail($id);

        if (empty($exchangeRate)) {
            return $this->sendError('Exchange Rate not found');
        }

        $exchangeRate = $this->exchangeRateRepository->update($input, $id);

        return $this->sendResponse($exchangeRate->toArray(), 'ExchangeRate updated successfully');
    }

    /**
     * Remove the specified ExchangeRate from storage.
     * DELETE /exchangeRates/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ExchangeRate $exchangeRate */
        $exchangeRate = $this->exchangeRateRepository->findWithoutFail($id);

        if (empty($exchangeRate)) {
            return $this->sendError('Exchange Rate not found');
        }

        $exchangeRate->delete();

        return $this->sendResponse($id, 'Exchange Rate deleted successfully');
    }
}
