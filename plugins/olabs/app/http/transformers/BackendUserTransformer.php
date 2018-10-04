<?php

namespace Olabs\App\Http\Transformers;

//use Olabs\Oims\Models\Project;
use League\Fractal\TransformerAbstract;
use Olabs\App\Classes\App;

class BackendUserTransformer extends App
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

        //parent::transform($item);
        $this->val = $item->toArray();

        $name =[$item->first_name,$item->last_name];
        $this->val['name'] = implode(" ", $name);

        if($item->avatar){
            $this->val['image_main'] = $item->getAvatarThumb(300);
        }else{
            $this->val['image_main'] =  "https://s3.amazonaws.com/assets-global/default.png";
        }

        return $this->val;


    }



}