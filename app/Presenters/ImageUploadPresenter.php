<?php

namespace App\Presenters;

use App\Transformers\ImageUploadTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ImageUploadPresenter.
 *
 * @package namespace App\Presenters;
 */
class ImageUploadPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ImageUploadTransformer();
    }
}
