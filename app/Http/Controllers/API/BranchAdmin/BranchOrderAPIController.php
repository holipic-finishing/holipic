<?php

namespace App\Http\Controllers\API\BranchAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Http\Controllers\AppBaseController;

class BranchOrderAPIController extends AppBaseController
{
	private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
    	$this->orderRepository = $orderRepository;
    }

    public function getSalesList() {

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

    public function exportSalesListBranch() {
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

    public function createLinkSale($branchId) {
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
}
