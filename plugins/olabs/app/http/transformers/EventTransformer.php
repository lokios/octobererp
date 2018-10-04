<?php

namespace Olabs\App\Http\Transformers;

//use Olabs\Oims\Models\Project;
use League\Fractal\TransformerAbstract;
use Olabs\App\Classes\App;

class EventTransformer extends App
{

   public  function getProps(){

        return ['content_type'=>'projectasset','uiview_detail'=>'group'];

    } 
/**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform( $item)
    {

        parent::transform($item);

        return $this->val;


    }



}