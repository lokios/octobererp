<?php

namespace Olabs\Social\Http\Controllers;

use Olabs\Social\Models\EntityRelations as EntityRelationsModel;
use Olabs\Social\Http\Transformers\EntityRelationsTransformer;
use Autumn\Api\Classes\ApiController;
use Illuminate\Http\Request;
class EntityRelations extends ApiController
{

    protected $defaultLimit = 5;

     protected $fillable  =['data','actor_id',"data","target_type","target_id","relation","request_id"];
     protected $fillable2  =['actor_id'];

     public $images_field = 'images';


    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new EntityRelationsModel;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new EntityRelationsTransformer;
    }

    public function getExtraConditions($action, Request $request , &$criteria ){
           $this->scopeEquals($criteria,'target_type');
           $this->scopeEquals($criteria,'actor_id');
           $this->scopeEquals($criteria,'status');
    }
}
