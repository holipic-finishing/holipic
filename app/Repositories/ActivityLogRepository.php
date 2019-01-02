<?php
namespace App\Repositories;

use DB ;
use Spatie\Activitylog\Models\Activity;
use App\Models\Company;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CompanyRepository
 * @package App\Repositories
 * @version December 10, 2018, 3:23 am UTC
 *
 * @method Company findWithoutFail($id, $columns = ['*'])
 * @method Company find($id, $columns = ['*'])
 * @method Company first($columns = ['*'])
*/
class ActivityLogRepository extends BaseRepository
{
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
                                 ->orderBy('date', 'desc')
                                 ->get()
                                 ->toArray();

        $array = [];

        foreach($activityLog as $value) 
        {
            $value['subject_type'] = substr($value['subject_type'], 11, strlen($value['subject_type']));
            $value['name'] = $company['name'];
            $array[] = $value;
        }

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
        ->paginate();

        return $query;
    }
}
