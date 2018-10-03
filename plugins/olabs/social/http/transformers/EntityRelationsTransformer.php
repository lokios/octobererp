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
        $dated = "";
        $stat = "";
        $subtitle = [];
        $subtitle2 = [];

        if($item->target_type == 'mr_entry'){
           
       
        
        
        $dated = date('Y-m-d H:i', strtotime($item->created_at));

        $this->val['data'] = $item->data;
        

         $attributes  = [];
         
         $attributes[] =['name'=>'Dated','value'=>$dated, 'type'=>'date'];


         $data = $item->data;

         if($data && is_array($data)){
            $data = $data[0];
            if(isset($data['to_project_id'])){
                $project = \Olabs\Oims\Models\Project::where(['id'=>$data['to_project_id']])->first();


                if($project){
                    $attributes[] =['name'=>'Project','value'=> $project->name ];
                    $subtitle[] = $project->name;

                }
         }

         if(isset($data['mr_id'])){
            $name = [];
            
            $name[] = 'MR no: '.$data['mr_id'];
            
          
           $attributes[] =['name'=>'MR no.','value'=>$data['mr_id']];
        }

         $this->val['name'] = implode(" | ", $name);

         $this->val['dated'] = $dated;
         $this->val['subtitle'] = implode(" | ", $subtitle);
         $this->val['subtitle2'] = implode(" | ", $subtitle2);
         $this->val['stat'] = $stat;

     }





         $this->val['attributes'] = $attributes;
          $this->val['summary_view'] = 'expandable';

     }


       if($item->target_type == 'voucher'){
           
       
        
        
        $dated = date('Y-m-d H:i', strtotime($item->created_at));

        $this->val['data'] = $item->data;
        

         $attributes  = [];
         
         $attributes[] =['name'=>'Dated','value'=>$dated, 'type'=>'date'];


         $data = $item->data;

         if($data && is_array($data)){
            $data = $data[0];
            if(isset($data['to_project_id'])){
                $project = \Olabs\Oims\Models\Project::where(['id'=>$data['to_project_id']])->first();


                if($project){
                    $attributes[] =['name'=>'Project','value'=> $project->name ];
                    $subtitle[] = $project->name;

                }
         }

         if(isset($data['voucher_number'])){
            $name = [];
            
            $name[] = 'voucher no: '.$data['voucher_number'];
            
          
           $attributes[] =['name'=>'voucher no.','value'=>$data['voucher_number']];
        }

         $this->val['name'] = implode(" | ", $name);

         $this->val['dated'] = $dated;
         $this->val['subtitle'] = implode(" | ", $subtitle);
         $this->val['subtitle2'] = implode(" | ", $subtitle2);
         $this->val['stat'] = $stat;

     }





         $this->val['attributes'] = $attributes;
         $this->val['summary_view'] = 'expandable';

     }

     if($item->target_type == 'attendance'){
           
        


       
        $this->val['name'] = implode(" | ", $name);
        $this->val['subtitle'] = ' dated: '.date('Y-m-d H:i', strtotime($item->created_at));
        

         $attributes  = [];
         $attributes[] =['name'=>'Emp ID.','value'=>$item->target_id];
         
         $data = $item->data;
         if($data && is_array($data)){
            $data = $data[0];


            

         if(isset($data['check_in'])){
              $dated = date('Y-m-d H:i', strtotime($data['check_in']));
              $attributes[] =['name'=>'Dated','value'=>$dated, 'type'=>'date'];
         }
          if(isset($data['employee_name'])){
              $name[] = $data['employee_name'];
              $attributes[] =['name'=>'Emp Name.','value'=>$data['employee_name']];
         }
          if(isset($data['employee_type'])){
              $attributes[] =['name'=>'Emp Type.','value'=>$data['employee_type']];
              $subtitle[] = $data['employee_type'];
         }
          if(isset($data['project_name'])){
              $attributes[] =['name'=>'Project.','value'=>$data['project_name']];
               $subtitle[] = $data['project_name'];
         }

          }

          $name[] = 'Emp ID: '.$item->target_id;
          $this->val['name'] = implode(" | ", $name);

         $this->val['dated'] = $dated;
         $this->val['subtitle'] = implode(" | ", $subtitle);
         $this->val['subtitle2'] = implode(" | ", $subtitle2);
         $this->val['stat'] = $stat;
         $this->val['attributes'] = $attributes;
          $this->val['summary_view'] = 'expandable';

     }



        return $this->val;


        return [
            'id'         => (int)$item->id,
            'created_at' => (string)$item->created_at,
            'updated_at' => (string)$item->updated_at,
        ];
    }
}
