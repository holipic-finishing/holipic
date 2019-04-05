<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Cart;

/**
 * Class CartTransformer.
 *
 * @package namespace App\Transformers;
 */
class CartTransformer extends TransformerAbstract
{
    /**
     * Transform the Cart entity.
     *
     * @param \App\Models\Cart $model
     *
     * @return array
     */
    public function transform(Cart $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
