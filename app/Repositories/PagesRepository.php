<?php

namespace App\Repositories;

use App\Models\CompanyAdmin\Pages;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PagesRepository
 * @package App\Repositories
 * @version January 2, 2019, 7:42 am UTC
 *
 * @method Pages findWithoutFail($id, $columns = ['*'])
 * @method Pages find($id, $columns = ['*'])
 * @method Pages first($columns = ['*'])
*/
class PagesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'page_title',
        'page_content'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Pages::class;
    }
}
