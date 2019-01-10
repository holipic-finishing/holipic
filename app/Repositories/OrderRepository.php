<?php

namespace App\Repositories;

use App\Models\Order;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class OrderRepository
 * @package App\Repositories
 * @version January 9, 2019, 6:50 am UTC
 *
 * @method Order findWithoutFail($id, $columns = ['*'])
 * @method Order find($id, $columns = ['*'])
 * @method Order first($columns = ['*'])
*/
class OrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'branch_id',
        'photographer_id',
        'customer_id',
        'total_amount',
        'purchase_date',
        'download_date',
        'payment_method',
        'purchase_from',
        'status',
        'invoice'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Order::class;
    }

    public function reportSaleDaily(){
        dd('daily');
    }

    public function reportSaleMonth(){
        dd('month');
    }

    public function reportSaleYear(){
        dd('year');
    }

    public function reportSaleWeek(){
        dd('week');
    }
    
    // ********* Get all orders with branch, customer, photographer **********
    public function getAllOrders($searchBy){

         if (!empty($searchBy['from_day']) && !empty($searchBy['to_day'])) {

                dd('hehe haha');
            }   else if(!empty($searchBy['to_day'])){
                dd('haha');
            } else if(!empty($searchBy['from_day'])){
               dd('hehe');
            }
            dd('ko co');
     


        $results = $this->scopeQuery(function($query) use ($searchBy){
             $query = $query->with(['branch' => function($q) {
                        $q->select('name','id');
                      }])
                      ->with(['customer.room' => function($q){
                        $q->select('room_hash','id');
                      }])
                      ->with(['customer.user' => function($q){
                        $q->select('email','id');
                      }])
                      ->with(['photographer' => function($q){
                        $q->select('id','name');
                      }]);

            if (!empty($searchBy['branch_id']) !== '0') {

                $query = $query->where('branch_id',$searchBy['branch_id']);
            }  

            if (!empty($searchBy['photographer_id']) !== '0') {

                $query = $query->where('photographer_id',$searchBy['photographer_id']);
            }  

            if (!empty($searchBy['from_day'])) {

                $query = $query->where(DB::raw('date(purchase_date)'),$searchBy['from_day']);
            }  

            if (!empty($searchBy['branch_id']) !== '0') {

                $query = $query->where('branch_id',$searchBy['branch_id']);
            }          
          
            $query = $query->where('status','DONE');
             return $query;
         })->get();
     
        $results = $this->transform($results);

        return $results;

    }

    //*********** Transfrom Orders data **************
    public function transform($results){

        foreach ($results as $key => $result) {
            $results[$key]->branch_name = $result->branch->name;
            $results[$key]->room_has_number = $result->customer->room->room_hash;
            $results[$key]->customer_email = $result->customer->user->email;
            $results[$key]->photographer_name = $result->photographer->name;
        }
        
        return $results;
    }
}
