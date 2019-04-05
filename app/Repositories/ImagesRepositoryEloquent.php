<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ImagesRepository;
use App\Models\Images;
use App\Validators\ImagesValidator;

/**
 * Class ImagesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ImagesRepositoryEloquent extends BaseRepository implements ImagesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Images::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
