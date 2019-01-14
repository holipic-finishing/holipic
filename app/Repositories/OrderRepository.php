<?php
namespace App\Repositories;

use DB ;
use App\Models\Order;
use InfyOm\Generator\Common\BaseRepository;

class OrderRepository extends BaseRepository {

	public function model()
    {
        return Order::class;
    }

    public function handleShowSaleListBranch($branchId, $search)
    {
    	
    	if($branchId && !empty($branchId)) {
    		
    		$sales = $this->scopeQuery(function($query) use ($branchId, $search){
    			$query = $query->with('branch')
    							->with(['customer' => function($q){
    								$q->with('user');
									$q->with('room');
								}])
								->with('photographer');

				$query = $query->whereBranchId($branchId);

				if(!empty($search)) {

					if(isset($search['photographerId']) && !empty($search['photographerId'])) {
						$query = $query->where('photographer_id', $search['photographerId']);	
					}

					if(isset($search['fromDate']) && $search['fromDate'] !=  'null' && 
						isset($search['toDate']) && $search['toDate'] != 'null'
					) {
						
						$query = $query->where(DB::raw('date(purchase_date)'), '>=', $search['fromDate'])
									   ->where(DB::raw('date(purchase_date)'), '<=', $search['toDate']);
					}
				}

				return $query;
			})->get();
    	}

    	if($sales) {
    		return $sales->toArray();
    	}

    	return false;
    }

    //********** Insert File CSV **************
   public function insertCSVFile($attributes, $branchId){
 
        if(!$attributes)
            return false;

        $pathPublic = env('DB_MYSQL_DIR').DIRECTORY_SEPARATOR;

        $fileName =  $branchId . '_SalesBranch.csv';

        $file = fopen($pathPublic.$fileName,"a+");
        try{

            foreach ($attributes as $key => $value) {
                $data = [];
                $data[] = $key;
                $data[] = $value['branch']['name'];
                $data[] = $value['photographer']['name'];
                $data[] = $value['customer']['room']['room_hash'];
                $data[] = $value['total_amount'];
                $data[] = $value['purchase_date'];
                $data[] = $value['customer']['user']['email'];
                $data[] = $value['payment_method'];
                $data[] = $value['purchase_from'];
                fputcsv($file, $data);
            }

            fclose($file);
        }catch (Exception $e)
        {
            \Log::info(' Errors to insert csv file - '.$e->getMessage());
        }

    }
	
}