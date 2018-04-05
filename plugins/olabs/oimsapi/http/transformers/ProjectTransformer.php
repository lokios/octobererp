<?php

namespace Olabs\Oimsapi\Http\Transformers;

use Olabs\Oims\Models\Project;
use League\Fractal\TransformerAbstract;
use Olabs\App\Classes\App;

class ProjectTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Project $item)
    {
        $app = App::getInstance();
        $base = $app->getBaseEndpoint();
        


        $val = $item->toArray();

        $val['content_type'] = 'project';

        
         if(isset($val['contact_email']) && $val['contact_email']){
            $val['email'] = $val['contact_email'];
        }

         if(isset($val['contact_phone']) && $val['contact_phone']){
            $val['phone_1'] = $val['contact_phone'];
        }
         $addr = [];

         if($item->company){
            $val['overiew'] =  'Company - '.$item->company->name;

             $addr[] = $item->company->name;
         }
         if(isset($val['contact_person'])){
            $addr[] = $val['contact_person'];
         }



         if(isset($val['address'])){
            $addr[] = $val['address'];
         }
         if(isset($val['address_2'])){
            $addr[] = $val['address_2'];
         }
         if(isset($val['city'])){
            $addr[] = $val['city'];
         }
         if(isset($val['state'])){
            $addr[] = $val['state'];
         }
         if(isset($val['country'])){
            $addr[] = $val['country'];
         }

         $val['address_fmt'] = implode(", ", $addr); 

        if(!$val['address_fmt'] )unset($val['address_fmt'] );
        
        $img = false;
        $val['bg_image'] = $img?$img:$app->getBaseEndpointImages().'/themes/octobererp_theme1/assets/images/construction/default_bg_image.jpg';
        $val['main_image'] = $img?$img:$app->getBaseEndpointImages().'/themes/octobererp_theme1/assets/images/construction/default_about.jpg';



         if($item){//->getDomainCode()=='ehr'){
          $modules = [];
          $fmodules = [];
          if($app->hasPermission($item,'manage_his')){
              $val['can_edit'] = false;
              
              $this->addHRMModule($item,$fmodules);
              $this->addAssetsModule($item,$fmodules);



 


          }

          $modules = $fmodules;

            $val['modules'] = $modules;
               
        }

        

        return $val;
        return [
            'id'         => (int)$item->id,
            'created_at' => (string)$item->created_at,
            'updated_at' => (string)$item->updated_at,
        ];
    }


    public function addHRMModule($item,&$fmodules){

         $app = App::getInstance();
        $base = $app->getBaseEndpoint();

          $modules = [];
          $module =[  'tenant_id'=>$item->id,'name'=>'Employees','list'=>$base.'/api/v1/employees','module'=>'user','edit_url2'=>$base.'/api/v1/employees',

              'create2'=>[
                  ['tenant_id'=>$item->id,'module'=>'user','url'=>$base.'/api/v1/employees','title'=>'Add Employee','format'=>'json','method'=>'post'],
                    

              ]
             ];$modules[] = $module;

             $module =[  'tenant_id'=>$item->id,'name'=>'Offrole Employees','list'=>$base.'/api/v1/offroleemployees?project_id='.$item->id,'module'=>'patients','edit_url'=>$base.'/api/v1/offroleemployees',

              'create2'=>[
                  ['tenant_id'=>$item->id,'module'=>'patients','url'=>$base.'/api/v1/offroleemployees','title'=>'Add Employee','format'=>'json','method'=>'post'],
                    

              ]
             ];

            $modules[] = $module;


            $module =[  'tenant_id'=>$item->id,'name'=>'Suppliers','list'=>$base.'/api/v1/suppliers','module'=>'users','edit_url2'=>$base.'/appoint/api/v1/suppliers',];
            $modules[] = $module;


           
           


             $module =[ 'item_type'=>'flat_list', 'tenant_id'=>$item->id,'name'=>'HRMS','list'=>$base.'/ehr/api/v1/'.$item->id.'/users','module'=>'patients','edit_url'=>$base.'/ehr/api/v1/users',

              'items'=>$modules
            ];

            
            $fmodules[] = $module;
    }



    public function addAssetsModule($item,&$fmodules){

        $app = App::getInstance();
        $base = $app->getBaseEndpoint();

          $modules = [];


             $modules = [];
             $module =[  'tenant_id'=>$item->id,'name'=>'Assets Management'
             ,'list'=>$base.'/api/v1/products?project_id='.$item->id,'module'=>'product','edit_url2'=>$base.'/api/v1/employees','barcode_enabled'=>true,

              'create2'=>[
                  ['tenant_id'=>$item->id,'module'=>'product','url'=>$base.'/api/v1/employees','title'=>'Add Employee','format'=>'json','method'=>'post'],
                    

              ]
             ];
             $modules[] = $module;
             /**

            $module =[  'tenant_id'=>$item->id,'name'=>'Assets Monitor Reports','list'=>$base.'/api/v1/projectassetmonitors/report?project_id=:project_id','module'=>'product','edit_url2'=>$base.'/api/v1/employees',
              'filters'=>[['name'=>'Filter by Product','type'=>'text_ac','item_id'=>'product_id','api'=>$base.'/api/v1/products'],
             ['name'=>'Select Dates','type'=>'date_range','item_id_from_date'=>'created_at_from','item_id_to_date'=>'created_at_to'],['name'=>'Till Date','id'=>'created_at_to']],

              'create2'=>[
                  ['tenant_id'=>$item->id,'module'=>'product','url'=>$base.'/api/v1/employees','title'=>'Add Employee','format'=>'json','method'=>'post'],
                    

              ]
             ];
             $modules[] = $module;
             
             $module =[  'tenant_id'=>$item->id,'name'=>'Assets Transfer Reports','list'=>$base.'/api/v1/projectassettransfers/report?project_id=:project_id','module'=>'product','edit_url2'=>$base.'/api/v1/employees',
              'filters'=>[['name'=>'Filter by Product','type'=>'text_ac','item_id'=>'product_id','api'=>$base.'/api/v1/products'],
             ['name'=>'Select Dates','type'=>'date_range','item_id_from_date'=>'created_at_from','item_id_to_date'=>'created_at_to'],['name'=>'Till Date','id'=>'created_at_to']],

              'create2'=>[
                  ['tenant_id'=>$item->id,'module'=>'product','url'=>$base.'/api/v1/employees','title'=>'Add Employee','format'=>'json','method'=>'post'],
                    

              ]
             ];$modules[] = $module;

             $module =[  'tenant_id'=>$item->id,'name'=>'Assets Damages Reports','list'=>$base.'/api/v1/projectassetdamages/report?project_id=:project_id','module'=>'product','edit_url2'=>$base.'/api/v1/employees',
              'filters'=>[['name'=>'Filter by Product','type'=>'text_ac','item_id'=>'product_id','api'=>$base.'/api/v1/products'],
             ['name'=>'Select Dates','type'=>'date_range','item_id_from_date'=>'created_at_from','item_id_to_date'=>'created_at_to'],['name'=>'Till Date','id'=>'created_at_to']],

              'create2'=>[
                  ['tenant_id'=>$item->id,'module'=>'product','url'=>$base.'/api/v1/employees','title'=>'Add Employee','format'=>'json','method'=>'post'],
                    

              ]
             ];

$modules[] = $module;
**/
 $module =[  'tenant_id'=>$item->id,'name'=>'Assets  Report','list'=>$base.'/api/v1/projectassets/report?project_id=:project_id','module'=>'projectassets','edit_url2'=>$base.'/api/v1/employees',
              'filters'=>[['name'=>'Filter by Product','type'=>'text_ac','item_id'=>'product_id','api'=>$base.'/api/v1/products'],
             ['name'=>'Select Dates','type'=>'date_range','item_id_from_date'=>'created_at_from','item_id_to_date'=>'created_at_to'],['name'=>'Till Date','id'=>'created_at_to']],

              'create2'=>[
                  ['tenant_id'=>$item->id,'module'=>'product','url'=>$base.'/api/v1/employees','title'=>'Add Employee','format'=>'json','method'=>'post'],
                    

              ]
             ];

$modules[] = $module;
             
           
           


             $module =[ 'item_type'=>'flat_list', 'tenant_id'=>$item->id,'name'=>'Assets','list'=>$base.'/ehr/api/v1/'.$item->id.'/users','module'=>'patients','edit_url'=>$base.'/ehr/api/v1/users',

              'items'=>$modules
            ];

            $fmodules[] = $module;



        }




        public function addAssetsModuleByProjectAssets(&$fmodules){

         $app = App::getInstance();
        $base = $app->getBaseEndpoint();

          $modules = [];


             $modules = [];
             $module =[  'tenant_id'=>$item->id,'name'=>'Assets Monitor','list'=>$base.'/api/v1/products','module'=>'product','edit_url2'=>$base.'/api/v1/employees',

              'create2'=>[
                  ['tenant_id'=>$item->id,'module'=>'product','url'=>$base.'/api/v1/employees','title'=>'Add Employee','format'=>'json','method'=>'post'],
                    

              ]
             ];
             $modules[] = $module;

             

             $module =[  'tenant_id'=>$item->id,'name'=>'Assets Transfers','list'=>$base.'/api/v1/products?project_id='.$item->id,'module'=>'product','edit_url2'=>$base.'/api/v1/employees',

              'create2'=>[
                  ['tenant_id'=>$item->id,'module'=>'product','url'=>$base.'/api/v1/employees','title'=>'Add Employee','format'=>'json','method'=>'post'],
                    

              ]
             ];
             $modules[] = $module;

              $module =[  'tenant_id'=>$item->id,'name'=>'Assets Damages','list'=>$base.'/api/v1/products?project_id='.$item->id,'module'=>'product','edit_url2'=>$base.'/api/v1/employees',

              'create2'=>[
                  ['tenant_id'=>$item->id,'module'=>'product','url'=>$base.'/api/v1/employees','title'=>'Add Employee','format'=>'json','method'=>'post'],
                    

              ]
             ];
             $modules[] = $module;


             
           
           


             $module =[ 'item_type'=>'flat_list', 'tenant_id'=>$item->id,'name'=>'Assets','list'=>$base.'/ehr/api/v1/'.$item->id.'/users','module'=>'patients','edit_url'=>$base.'/ehr/api/v1/users',

              'items'=>$modules
            ];

            $fmodules[] = $module;



        }

}
