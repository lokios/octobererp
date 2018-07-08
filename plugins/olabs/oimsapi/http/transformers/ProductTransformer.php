<?php

namespace Olabs\Oimsapi\Http\Transformers;

use Olabs\Oims\Models\Project;
use Olabs\Oims\Models\ProjectAsset;
use Input;
use League\Fractal\TransformerAbstract;
use Olabs\App\Classes\App;

class ProductTransformer extends App
{

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

        $this->val['content_type'] = 'product';

         $img = false;
        $this->val['bg_image'] = $img?$img:$app->getBaseEndpointImages().'/themes/octobererp_theme1/assets/images/construction/default_bg_image.jpg';
        $this->val['main_image'] = $img?$img:$app->getBaseEndpointImages().'/themes/octobererp_theme1/assets/images/construction/default_about.jpg';

         
         $input = Input::all();
         $project_id = isset($input['project_id'])?$input['project_id']:-1;


         $model = ProjectAsset::where('project_id',$project_id)
                    ->where('product_id',$item->id)
                    ->first();
         $quantity = 0;   
         if(!$model){
             $this->val['subtitle'] = 'Nil inventory';

         }else{
            $this->val['subtitle'] = '('.$model->quantity.') inventory';
            $quantity = $model->quantity;
         }





         if($item){//->getDomainCode()=='ehr'){
          $modules = [];
          $fmodules = [];
          if($app->hasPermission($item,'manage_his')){
              $val['can_edit'] = true;

              
              $this->addAssetsModule($item,$fmodules,$quantity,$this->val['subtitle']);
              

            

 


          }

          $modules = $fmodules;

            $this->val['modules'] = $modules;
               
        }





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



     public function addAssetsModule($item, &$fmodules,$quantity,$subtitle){

         $app = App::getInstance();
         $base = $app->getBaseEndpoint();

           $modules = [];
             $module =[  'tenant_id'=>$item->id,'name'=>'Monitor','subtitle'=>$subtitle,'list'=>$base.'/api/v1/projectassetmonitors?project_id=:project_id&product_id='.$item->id,'module'=>'projectassetmonitor','edit_url2'=>$base.'/api/v1/project_assets_monitor',

              'create'=>[
                  ['data'=>['product_id'=>$item->id],'module'=>'projectassetmonitor','url'=>$base.'/api/v1/projectassetmonitors','title'=>'Monitor Asset','subtitle'=>$subtitle,'format'=>'json','method'=>'post'],
                    

              ]
             ];
             $modules[] = $module;


           if($quantity > 0){
             $module =[  'tenant_id'=>$item->id,'name'=>'Transfer','subtitle'=>$subtitle,'list'=>$base.'/api/v1/projectassettransfers?project_id=:project_id&product_id='.$item->id,'module'=>'projectassettransfer','edit_url2'=>$base.'/api/v1/projectassettransfers',

              'create'=>[ 
                  ['validations'=>['quantity'=>['max'=>$quantity]],'data'=>['product_id'=>$item->id],'module'=>'projectassettransfer','url'=>$base.'/api/v1/projectassettransfers','title'=>'Transfer Asset','subtitle'=>$subtitle,'format'=>'json','method'=>'post'],
                    

              ]
             ];
             $modules[] = $module;

              $module =[  'tenant_id'=>$item->id,'name'=>'Damages','subtitle'=>$subtitle,'list'=>$base.'/api/v1/projectassetdamages?project_id=:project_id&product_id='.$item->id,'module'=>'projectassetdamage','edit_url2'=>$base.'/api/v1/projectassetdamages',

              'create'=>[
                  ['validations'=>['quantity'=>['max'=>$quantity]],'data'=>['product_id'=>$item->id],'module'=>'projectassetdamage','url'=>$base.'/api/v1/projectassetdamages','title'=>'Report Damage','subtitle'=>$subtitle,'format'=>'json','method'=>'post'],
                    

              ]
             ];
             $modules[] = $module;

           }


             
           
           


             $module =[ 'item_type'=>'flat_list', 'tenant_id'=>$item->id,'name'=>'Assets','list'=>$base.'/ehr/api/v1/'.$item->id.'/users','module'=>'patient','edit_url'=>$base.'/ehr/api/v1/users',

              'items'=>$modules
            ];

            $fmodules[] = $module;


        }



   

    
}