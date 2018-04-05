<?php

namespace Olabs\Oimsapi\Http\Controllers;

use Olabs\Oims\Models\ProjectAssetDamage  ;
use Olabs\Oimsapi\Http\Transformers\ProjectAssetDamageTransformer;
use Autumn\Api\Classes\ApiController;
use Illuminate\Http\Request;
class ProjectAssetDamages extends ApiController
{


     public $fillable = ['quantity','project_id','product_id','context_date'];
     public $search_like_based = ['title'];
     public $images_field = 'images';

     public $orderBy = 'created_at';
     public $orderByOrder = 'desc';



    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new ProjectAssetDamage;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new ProjectAssetDamageTransformer;
    }


     public function getExtraConditions($action, Request $request , &$criteria ){
           $this->scopeEquals($criteria,'project_id');
           $this->scopeEquals($criteria,'product_id');

    }
}
