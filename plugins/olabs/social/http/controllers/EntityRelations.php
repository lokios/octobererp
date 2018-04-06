<?php

namespace Olabs\Social\Http\Controllers;

use Olabs\Social\Models\EntityRelations as EntityRelationsModel;
use Olabs\Social\Http\Transformers\EntityRelationsTransformer;
use Autumn\Api\Classes\ApiController;

class EntityRelations extends ApiController
{

    protected $defaultLimit = 5;

     protected $fillable  =['data','actor_id',"data","target_type","target_id","relation"];
 protected $fillable2  =['actor_id'];


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
}
