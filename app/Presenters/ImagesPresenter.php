<?php

namespace App\Presenters;

use App\Transformers\ImagesTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ImagesPresenter.
 *
 * @package namespace App\Presenters;
 */
class ImagesPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ImagesTransformer();
    }
}
