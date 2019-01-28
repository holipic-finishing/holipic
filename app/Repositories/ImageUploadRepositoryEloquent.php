<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ImageUploadRepository;
use App\Models\ImageUpload;
use App\Validators\ImageUploadValidator;

/**
 * Class ImageUploadRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ImageUploadRepositoryEloquent extends BaseRepository implements ImageUploadRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ImageUpload::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
