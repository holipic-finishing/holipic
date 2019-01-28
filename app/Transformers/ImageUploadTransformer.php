<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\ImageUpload;

/**
 * Class ImageUploadTransformer.
 *
 * @package namespace App\Transformers;
 */
class ImageUploadTransformer extends TransformerAbstract
{
    /**
     * Transform the ImageUpload entity.
     *
     * @param \App\Entities\ImageUpload $model
     *
     * @return array
     */
    public function transform(ImageUpload $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
