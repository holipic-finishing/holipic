<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Repositories\OrderRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Maatwebsite\Excel\Excel;
use App\Exports\ListEmailCustomers;
use App\Http\Requests\API\CreateOrderAPIRequest;
use App\Http\Requests\API\UpdateOrderAPIRequest;
use App\Models\Order;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class OrderAPIController extends AppBaseController
{
	protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
    	$this->orderRepository = $orderRepository;
    }

    public function getSalesList()
    {
    	$searchBy = [];

    	if(request('search') && request('search') != '') {

    		$searchValues = explode(';', request('search'));
            
            foreach ($searchValues as $val) {
            	$tmp = explode(':', $val);
    
                if(count($tmp) > 1){
                    $searchBy[$tmp[0]] = $tmp[1];
                }
            }

            if(isset($searchBy['fromDate']) && $searchBy['fromDate'] != 'null' &&
                isset($searchBy['toDate']) && $searchBy['toDate'] != 'null')
            {
                $fromDate = Carbon::parse($searchBy['fromDate']);
                $toDate = Carbon::parse($searchBy['toDate']);

                if($fromDate >= $toDate) {
                    return $this->sendError('Start date must be less than the end date');
                }
            }
    	}

    	$data = $this->orderRepository->handleShowSaleListBranch(request('branchId'), $searchBy);

    	if (empty($data)) {
            return $this->sendError('Not data');
        }

        return $this->sendResponse($data, 'Get Sales list success');
    }

    public function createLinkSale($branchId)
    {
        $path = env('DB_MYSQL_DIR') . DIRECTORY_SEPARATOR;
        
        $csvPath = $path .$branchId. '_SalesBranch.csv';

        if(\File::exists($csvPath)){
            unlink($csvPath);
        }
        if(!\File::exists($path)) {

            \File::makeDirectory($path, $mode = 0777, true, true);
        }

        $file = fopen($csvPath,"a+");

        $keys = ['SN.','Branch','Photographer','Room Number','Total Amount','Date','Customer Email','Payment Method','Purchased From'];
        fputcsv($file,$keys);
        fclose($file); 
        return $csvPath;
    }

    public function exportSalesListBranch()
    {
        $this->createLinkSale(request('branchId'));

        if(request('search') && request('search') != '') {

            $searchValues = explode(';', request('search'));
            
            foreach ($searchValues as $val) {
                $tmp = explode(':', $val);
    
                if(count($tmp) > 1){
                    $searchBy[$tmp[0]] = $tmp[1];
                }
            }

            if(isset($searchBy['fromDate']) && $searchBy['fromDate'] != 'null' &&
                isset($searchBy['toDate']) && $searchBy['toDate'] != 'null')
            {
                $fromDate = Carbon::parse($searchBy['fromDate']);
                $toDate = Carbon::parse($searchBy['toDate']);

                if($fromDate >= $toDate) {
                    return 'Start date must be less than the end date';
                }
            }
        }

        $sales = $this->orderRepository->handleShowSaleListBranch(request('branchId'), $searchBy);

        if ($sales) {
            $file_csv = $this->orderRepository->insertCSVFileBranch($sales, request('branchId'));

            return \Response::json([
                    'status' => true,
                    'link' => url('/files/'.request('branchId').'_SalesBranch.csv')
            ]);
        }

        //return \Excel::download(new ListEmailCustomers(request('branchId'), $searchBy), 'SalesListBranch.xlsx');
    }

    /**
     * Display a listing of the Order.
     * GET|HEAD /orders
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->orderRepository->pushCriteria(new RequestCriteria($request));
        $this->orderRepository->pushCriteria(new LimitOffsetCriteria($request));

        $orders = $this->orderRepository->all();

        return $this->sendResponse($orders->toArray(), 'Orders retrieved successfully');
       
    }

    /**
     * Store a newly created Order in storage.
     * POST /orders
     *
     * @param CreateOrderAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateOrderAPIRequest $request)
    {
        $input = $request->all();

        $orders = $this->orderRepository->create($input);

        return $this->sendResponse($orders->toArray(), 'Order saved successfully');
    }

    /**
     * Display the specified Order.
     * GET|HEAD /orders/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Order $order */
        $order = $this->orderRepository->findWithoutFail($id);

        if (empty($order)) {
            return $this->sendError('Order not found');
        }

        return $this->sendResponse($order->toArray(), 'Order retrieved successfully');
    }

    /**
     * Update the specified Order in storage.
     * PUT/PATCH /orders/{id}
     *
     * @param  int $id
     * @param UpdateOrderAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOrderAPIRequest $request)
    {
        $input = $request->all();

        /** @var Order $order */
        $order = $this->orderRepository->findWithoutFail($id);

        if (empty($order)) {
            return $this->sendError('Order not found');
        }

        $order = $this->orderRepository->update($input, $id);

        return $this->sendResponse($order->toArray(), 'Order updated successfully');
    }

    /**
     * Remove the specified Order from storage.
     * DELETE /orders/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Order $order */
        $order = $this->orderRepository->findWithoutFail($id);

        if (empty($order)) {
            return $this->sendError('Order not found');
        }

        $order->delete();

        return $this->sendResponse($id, 'Order deleted successfully');
    }

    /**
     * Target : Get all order company
     * GET orders/orders-company
     *
     * @param  array search
     *
     * @return Response
     */
    public function getAllOrderCompany(Request $request) 
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

        $orders = $this->orderRepository->getAllOrders($input['company_id'],$searchBy);
        if ($orders) {
            return $this->sendResponse($orders->toArray(), 'Orders retrieved successfully');
        }else{
            return $this->sendError('Data not found');
        }
    }


    /**
     * Target : Export file csv Sales Company
     * GET order/sales/company/export
     *
     * @param  array search
     *
     * @return Response
     */
    public function exportSalesCompany(Request $request)
    {
        $input = $request->all();
        $this->createLink($input['company_id']);

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

        $orders = $this->orderRepository->getAllOrders($input['company_id'],$searchBy);

        if ($orders) {
            $file_csv = $this->orderRepository->insertCSVFile($orders,$input['company_id']);
            return \Response::json([
                    'status' => true,
                    'link' => url('/files/'.$input['company_id'].'_Sales.csv')
            ]);
        }

    }

    /**
     * Target : Create file CSV sales HEADER
     * @From : func: getAllOrderCompany
     *
     * @param  array search
     *
     * 
     */
    public function createLink($company_id)
    {

        $path = public_path() . '/files' . DIRECTORY_SEPARATOR;

        $csvPath = $path .$company_id. '_Sales.csv';

        if(\File::exists($csvPath)){
            unlink($csvPath);
        }
        if(!\File::exists($path)) {
            \File::makeDirectory($path, $mode = 0777, true, true);
        }

        $file = fopen($csvPath,"a+");

        $keys = ['SN.','Branch','Photographer','Room Number','Total Amount','Date','Customer Email','Payment Method','Purchased From'];
        fputcsv($file,$keys);
        fclose($file); 
        return $csvPath;
    }


    /**
     *
     * get infomation of order table
     *
     */
    
    public function getHistoryOrders(Request $request)
    {
        $input = $request->all();
        if(isset($input['type'])){
            $results =  $this->orderRepository->getHistoryOrders($input);
        }else{

            if ($request->has(['defaultDay'])) {
                $input['type'] = 'day';
                $results =  $this->orderRepository->getHistoryOrders($input);
            } 
            if ($request->has(['defaultWeek'])) {
                $input['type'] = 'week';
                $results =  $this->orderRepository->getHistoryOrders($input);
            } 
            if ($request->has(['defaultMonth'])) {
                $input['type'] = 'month';
                $results =  $this->orderRepository->getHistoryOrders($input);
            } 
            if ($request->has(['defaultYear'])) {
                $input['type'] = 'year';
                $results =  $this->orderRepository->getHistoryOrders($input);
            }

           
        }
        return $this->sendResponse($results->toArray(), 'Order updated successfully');
    }

    public function countIncome(Request $request){
        $input = $request->all();
        if(isset($input['type'])){
            $results =  $this->orderRepository->countIncome($input);
        }else{

            if ($request->has(['defaultDay'])) {
                $input['type'] = 'day';
                $results =  $this->orderRepository->countIncome($input);
            } 
            if ($request->has(['defaultWeek'])) {
                $input['type'] = 'week';
                $results =  $this->orderRepository->countIncome($input);
            } 
            if ($request->has(['defaultMonth'])) {
                $input['type'] = 'month';
                $results =  $this->orderRepository->countIncome($input);
            } 
            if ($request->has(['defaultYear'])) {
                $input['type'] = 'year';
                $results =  $this->orderRepository->countIncome($input);
            }

           
        }
        return $this->sendResponse($results, 'Order updated successfully');
    }

   

}
