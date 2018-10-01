<?php

namespace Olabs\Oimsapi\Http\Controllers;

use Olabs\Oims\Models\Product  ;
use Olabs\Oimsapi\Http\Transformers\ProductTransformer;
use Autumn\Api\Classes\ApiController;

class Products extends ApiController
{

     public $search_like_based = ['title','id'];
     public $search_barcode_based = ['id'];
     public $filter_scopes =['title','id'];
     
    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new Product;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new ProductTransformer;
    }
}
