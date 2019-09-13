<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Images;

/**
 * Class ImagesTransformer.
 *
 * @package namespace App\Transformers;
 */
class ImagesTransformer extends TransformerAbstract
{
    /**
     * Transform the Images entity.
     *
     * @param \App\Models\Images $model
     *
     * @return array
     */
    public function transform(Images $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
