<?php

namespace Olabs\Oimsapi\Http\Controllers;

use Olabs\Oims\Models\ProjectAssetTransfer  ;
use Olabs\Oimsapi\Http\Transformers\ProjectAssetTransferTransformer;
use Autumn\Api\Classes\ApiController;
use Illuminate\Http\Request;


class ProjectAssetTransfers extends ApiController
{


     public $fillable = ['quantity','project_id','product_id','to_project_id','context_date'];
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
        return new ProjectAssetTransfer;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new ProjectAssetTransferTransformer;
    }


     public function getExtraConditions($action, Request $request , &$criteria ){
           $q2 =  $this->request->input('scope', false);
           if($q2 =='all_recent_entries'){
             $this->scopeEquals($criteria,'project_id');

           }else{
               $this->scopeEquals($criteria,'project_id');
               $this->scopeEquals($criteria,'product_id');
           }
    }
}
