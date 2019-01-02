<?php
namespace App\Repositories;

use DB ;
use Spatie\Activitylog\Models\Activity;
use App\Models\Company;

/**
 * Class CompanyRepository
 * @package App\Repositories
 * @version December 10, 2018, 3:23 am UTC
 *
 * @method Company findWithoutFail($id, $columns = ['*'])
 * @method Company find($id, $columns = ['*'])
 * @method Company first($columns = ['*'])
*/
class ActivityLogRepository extends BaseRepo
{
    /**
     * @var array
     */
   

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Activity::class;
    }

    public function handleShowActivityLog($request)
    {
        $company = Company::where('owner_id', $request['userId'])->first()->toArray();

        $activityLog = $this->model->select('id', 'subject_type' , 'description', 'properties', 
                                    DB::raw("DATE_FORMAT(updated_at,'%Y-%c-%d') as date"), 'updated_at', 'user_id')
                                 ->where('user_id', $request['userId'])
                                 ->orderBy('date', 'desc')->get()->toArray();

        $array = [];

        foreach($activityLog as $value) 
        {
            $value['subject_type'] = substr($value['subject_type'], 11, strlen($value['subject_type']));
            $value['name'] = $company['name'];
            $array[] = $value;
        }

        // foreach($activeLog as $value) 
        // {

        //     foreach($value['properties'] as $key=>$valueProperty) 
        //     {
        //         if($key == 'attributes')
        //         {
        //             if($valueProperty['company_id'] == $company['id']) {
        //                 $value['subject_type'] = substr($value['subject_type'], 11, strlen($value['subject_type']));

        //                 $array[] = $value;
        //             } 
        //         }
                
        //     }
            
        // }

        // $times = $this->groupTimeActivityLog();

        // $data = [];

        // $length = count($times);

        // $j = 0;

        // for($i = 0; $i < $length; $i++){
        //     foreach($activeLog as $value){
        //         if($value['date'] == $times[$i]['date']) {
        //             $time = $times[$i]['date'];
        //             $data[$times[$i]['date']][$j] = $value;
        //             $j++;
        //         } else {
        //             $j = 0;
        //         }
        //     }

        // }
        

        return $array;
    }

    public function groupTimeActivityLog($limit = null)
    {
        $query = $this->model->when(request('userId'), function($q){
            return $q->whereUserId(request('userId'));
        })
        ->latest(DB::raw("DATE_FORMAT(updated_at,'%Y-%c-%d')"))
        ->groupBy(DB::raw("DATE_FORMAT(updated_at,'%Y-%c-%d')"))
        ->selectRaw("DATE_FORMAT(updated_at,'%Y-%c-%d') as date")
        ->paginate($this->getLimit(request('perPage')));

        // $date = $this->model->orderBy(DB::raw("DATE_FORMAT(updated_at,'%Y-%c-%d')"), 'desc')
        //                     ->groupBy(DB::raw("DATE_FORMAT(updated_at,'%Y-%c-%d')"))
        //                     ->selectRaw("DATE_FORMAT(updated_at,'%Y-%c-%d') as date")
        //                     ->where('user_id', request('userId'));

        // $date = $date->paginate(request('perPage'));
        return $query;
    }
}
