<?php

namespace App\Repositories;

use App\Models\File;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FileRepository
 * @package App\Repositories
 * @version December 12, 2018, 4:03 am UTC
 *
 * @method File findWithoutFail($id, $columns = ['*'])
 * @method File find($id, $columns = ['*'])
 * @method File first($columns = ['*'])
*/
class FileRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'storage_url',
        'file_size',
        'uploaded_date',
        'company_id',
        'user_id',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return File::class;
    }
}
