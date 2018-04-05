<?php

namespace Olabs\Oimsapi\Http\Transformers;

use Olabs\Oims\Models\Project;
use League\Fractal\TransformerAbstract;
use Olabs\App\Classes\App;

class ProjectAssetTransformer extends App
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

        //return $this->val;

        
       $name = [];
        if($item->project){
            $name[] = $item->project->name;
        }
        if($item->product){
            $name[] = $item->product->title;
        }
        $this->val['name'] = implode(" | ", $name);
        $this->val['subtitle'] = "Purchase Quantity: ".$item->purchase_quantity.' dated: '.date('Y-m-d H:i', strtotime($item->created_at));


         $attributes  = [];
         $attributes[] =['name'=>'Purchase Quantity','value'=>$item->purchase_quantity];
          $attributes[] =['name'=>'Damage Quantity','value'=>$item->damage_quantity];
          $attributes[] =['name'=>'TF Quantity','value'=>$item->tf_quantity];
          $attributes[] =['name'=>'TT Quantity','value'=>$item->tt_quantity];
         $attributes[] =['name'=>'Dated','value'=>date('Y-m-d H:i', strtotime($item->created_at))];
         $this->val['attributes'] = $attributes;
        

      
        return $this->val;


        

        
        return [
            'id'         => (int)$item->id,
            'created_at' => (string)$item->created_at,
            'updated_at' => (string)$item->updated_at,
        ];
    }


    public function getAvailableIncludes(){
    	return [];//'product','project'];
    }


     
   
    

	
}
