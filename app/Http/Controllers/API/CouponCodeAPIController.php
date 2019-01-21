<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCouponCodeAPIRequest;
use App\Http\Requests\API\UpdateCouponCodeAPIRequest;
use App\Models\CouponCode;
use App\Repositories\CouponCodeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CouponCodeController
 * @package App\Http\Controllers\API
 */

class CouponCodeAPIController extends AppBaseController
{
    /** @var  CouponCodeRepository */
    private $couponCodeRepository;

    public function __construct(CouponCodeRepository $couponCodeRepo)
    {
        $this->couponCodeRepository = $couponCodeRepo;
    }

    /**
     * Display a listing of the CouponCode.
     * GET|HEAD /couponCodes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->couponCodeRepository->pushCriteria(new RequestCriteria($request));
        $this->couponCodeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $couponCodes = $this->couponCodeRepository->all();

        return $this->sendResponse($couponCodes->toArray(), 'Coupon Codes retrieved successfully');
    }

    /**
     * Store a newly created CouponCode in storage.
     * POST /couponCodes
     *
     * @param CreateCouponCodeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCouponCodeAPIRequest $request)
    {
        $input = $request->all();
        $couponCodes = $this->couponCodeRepository->create($input);

        return $this->sendResponse($couponCodes->toArray(), 'Coupon Code saved successfully');
    }

    /**
     * Display the specified CouponCode.
     * GET|HEAD /couponCodes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CouponCode $couponCode */
        $couponCode = $this->couponCodeRepository->findWithoutFail($id);

        if (empty($couponCode)) {
            return $this->sendError('Coupon Code not found');
        }

        return $this->sendResponse($couponCode->toArray(), 'Coupon Code retrieved successfully');
    }

    /**
     * Update the specified CouponCode in storage.
     * PUT/PATCH /couponCodes/{id}
     *
     * @param  int $id
     * @param UpdateCouponCodeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCouponCodeAPIRequest $request)
    {
        $input = $request->all();

        /** @var CouponCode $couponCode */
        $couponCode = $this->couponCodeRepository->findWithoutFail($id);

        if (empty($couponCode)) {
            return $this->sendError('Coupon Code not found');
        }

        $couponCode = $this->couponCodeRepository->update($input, $id);

        return $this->sendResponse($couponCode->toArray(), 'CouponCode updated successfully');
    }

    /**
     * Remove the specified CouponCode from storage.
     * DELETE /couponCodes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CouponCode $couponCode */
        $couponCode = $this->couponCodeRepository->findWithoutFail($id);

        if (empty($couponCode)) {
            return $this->sendError('Coupon Code not found');
        }

        $couponCode->delete();

        return $this->sendResponse($id, 'Coupon Code deleted successfully');
    }

    /**
     * Edit Coupon Code with field
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function editCouponCode(Request $request, $itemId)
    {
        $input =  $request->all();

        if (!$input['value'] && $input['field_name'] != 'active') {
            return $this->sendError('This field could be not null');
        }

        $result = null;

        $result = $this->couponCodeRepository->update([
            $input['field_name'] => $input['value']
        ], $itemId);

        // Save activity log
        // $log = Activity::all()->last();
        // $log['user_id'] = $input['userId'];
        // $log->save();

        if($result){
            return $this->sendResponse([], 'Coupon code updated successfully');
        }else{
            return $this->sendError('System Error Occurred');
        }
    }
}
