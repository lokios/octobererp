<?php

namespace Olabs\Oimsapi\Http\Transformers;

use Olabs\Oims\Models\Project;
use League\Fractal\TransformerAbstract;
use Olabs\App\Classes\App;

class ProjectAssetTransferTransformer extends App
{
public $images_field = 'images';

   public  function getProps(){

        return ['content_type'=>'projectassettransfer','uiview_detail'=>'group'];

    } 

     
    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform( $item)
    {
       $app = App::getInstance();
       $base = $app->getBaseEndpoint();
        parent::transform($item);

        

        $name = [];
        if($item->project){
            $name[] = $item->project->name;
        }
        if($item->product){
            $name[] = $item->product->title;
        }
        $this->val['name'] = implode(" | ", $name);
        $this->val['subtitle'] = "Quantity: ".$item->quantity.' dated: '.date('Y-m-d H:i', strtotime($item->context_date));
        

         $attributes  = [];

          if($item->project_to){
           
             $attributes[] =['name'=>'Transfered to Project','value'=>$item->project_to->name];
        }

         $attributes[] =['name'=>'Quantity','value'=>$item->quantity];
         $attributes[] =['name'=>'Dated','value'=>date('Y-m-d H:i', strtotime($item->context_date))];
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
