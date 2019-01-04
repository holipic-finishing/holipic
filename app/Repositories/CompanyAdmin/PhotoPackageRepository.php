<?php

namespace App\Repositories\CompanyAdmin;

use App\Models\PhotoPackage;
use App\Models\Currency;
use InfyOm\Generator\Common\BaseRepository;
use DB ;

/**
 * Class PhotoPackageRepository
 * @package App\Repositories
 * @version January 3, 2019, 7:19 am UTC
 *
 * @method PhotoPackage findWithoutFail($id, $columns = ['*'])
 * @method PhotoPackage find($id, $columns = ['*'])
 * @method PhotoPackage first($columns = ['*'])
*/
class PhotoPackageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'size',
        'price',
        'free_photo',
        'currency_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PhotoPackage::class;
    }

    public function getPhotoPackage()
    {
        $results = DB::table('photo_packages as p')
                    ->join('currencies as c', 'c.id', '=', 'p.currency_id')
                    ->select('p.id as id', 'p.size','p.price' ,'p.free_photo', 'c.symbol')
                    ->get();

        return $results;
    }
}
