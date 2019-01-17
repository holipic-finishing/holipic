<?php

namespace App\Repositories\CompanyAdminRepositories;

use App\Models\CompanyAdmin\Email;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EmailRepository
 * @package App\Repositories
 * @version January 11, 2019, 3:39 am UTC
 *
 * @method Email findWithoutFail($id, $columns = ['*'])
 * @method Email find($id, $columns = ['*'])
 * @method Email first($columns = ['*'])
*/
class EmailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'email_title',
        'email_content',
        'format_email_content'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Email::class;
    }
}
