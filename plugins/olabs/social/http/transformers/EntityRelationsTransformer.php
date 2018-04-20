<?php

namespace Olabs\Social\Http\Transformers;

use Olabs\Social\Models\EntityRelations;
use League\Fractal\TransformerAbstract;

use Olabs\App\Classes\App;

class EntityRelationsTransformer extends App
{
     public $images_field = 'images';


     public  function getProps(){

        return ['content_type'=>'EntityRelations','uiview_detail'=>'group'];

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
        if($item->relation == 'mr_entry'){
            $name[] = 'MR Entry';
            $name[] = $item->context_id;
        


       
        $this->val['name'] = implode(" | ", $name);
        $this->val['subtitle'] = ' dated: '.date('Y-m-d H:i', strtotime($item->created_at));

        $this->val['data'] = $item->data;
        

         $attributes  = [];
         $attributes[] =['name'=>'MR No.','value'=>$item->context_id];
         $attributes[] =['name'=>'Dated','value'=>date('Y-m-d H:i', strtotime($item->created_at))];



         $this->val['attributes'] = $attributes;

     }

     if($item->relation == 'attendance'){
            $name[] = 'Attendance Entry/ Emp ID: ';
            $name[] = $item->context_id;
        


       
        $this->val['name'] = implode(" | ", $name);
        $this->val['subtitle'] = ' dated: '.date('Y-m-d H:i', strtotime($item->created_at));
        

         $attributes  = [];
         $attributes[] =['name'=>'Employee ID.','value'=>$item->context_id];
         
         $data = $item->data;
         if($data && is_array($data)){
            $data = $data[0];


            

         if(isset($data['check_in'])){
              $attributes[] =['name'=>'Dated','value'=>date('Y-m-d H:i', strtotime($data['check_in']))];
         }
          if(isset($data['employee_name'])){
              $attributes[] =['name'=>'Emp Name.','value'=>$data['employee_name']];
         }
          if(isset($data['employee_type'])){
              $attributes[] =['name'=>'Emp Type.','value'=>$data['employee_type']];
         }
          if(isset($data['project_name'])){
              $attributes[] =['name'=>'Project.','value'=>$data['project_name']];
         }

          }
         $this->val['attributes'] = $attributes;

     }



        return $this->val;


        return [
            'id'         => (int)$item->id,
            'created_at' => (string)$item->created_at,
            'updated_at' => (string)$item->updated_at,
        ];
    }
}
