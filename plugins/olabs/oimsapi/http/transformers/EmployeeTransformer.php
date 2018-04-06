<?php

namespace Olabs\Oimsapi\Http\Transformers;

use Olabs\Oims\Models\Employee;
use League\Fractal\TransformerAbstract;
use Olabs\App\Classes\App;
class EmployeeTransformer extends TransformerAbstract
{


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
        $val = $item->toArray();
        $val['content_type'] = 'employee';
        $val['uiview_detail'] = 'group';


        $val['name'] = [$val['first_name'],$val['last_name']];//,'uid'.$app->getAppUserId(),'perm'.$app->hasPermission($org,'manage_his')];
        $val['name']  =  implode(" ", $val['name']);
        $addr = [];
        if(isset($val['contact_email']) && $val['contact_email']){
            $val['email'] = $val['contact_email'];
        }

         if(isset($val['contact_phone']) && $val['contact_phone']){
            $val['phone_1'] = $val['contact_phone'];
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

         foreach ($val as $key => $value) {
          # code...
          if(!$value ||  $value==''){
              unset($val[$key]);
          }
        }



        
        $img = false;
        $val['bg_image'] = $img?$img:$app->getBaseEndpointImages().'/themes/octobererp_theme1/assets/images/construction/default_bg_image.jpg';
        $val['main_image'] = $img?$img:$app->getBaseEndpointImages().'/themes/octobererp_theme1/assets/images/construction/default_about.jpg';


       
          $modules = [];
          $fmodules = [];
          if($app->hasPermission($item,'manage_his')){
              $val['can_edit'] = false;
              
              $this->addHRMModule($item,$fmodules);
              

          }

          
          $modules = [];
          $fmodules = [];
          if($app->hasPermission($item,'manage_his')){
              $val['can_edit'] = false;
              
              $this->addHRMModule($item,$fmodules);
              

          }

          $modules = $fmodules;

          $val['modules'] = $modules;
            $val['actions'] = $modules[0];



      



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
$val = $item->toArray();
        
        $val['name'] = [$val['first_name'],$val['last_name']];//,'uid'.$app->getAppUserId(),'perm'.$app->hasPermission($org,'manage_his')];
        $val['name']  =  implode(" ", $val['name']);

          $module = ['item_type'=>'post'
          ,'data'=>['employee_type'=>'onrole','employee_id'=>$item->id]
          ,'module'=>'attendance','url'=>$base.'/api/v1/attendances','edit_url'=>$base.'/api/v1/attendances','name'=>'Add Attendance'
,'title'=>'Add Attendance'
,'subtitle'=>$val['name']
          ,'format'=>'json','method'=>'post'];
            $modules[] = $module;

           $module =[  'item_type'=>'list','employee_id'=>$item->id,'name'=>'Attendance Entries','list'=>$base.'/api/v1/attendances?employee_type=onrole&employee_id='.$item->id,'module'=>'user','edit_url2'=>$base.'/api/v1/attendances','barcode_enabled'=>false,

              'create2'=>[
                  ['tenant_id'=>$item->id,'module'=>'user','url'=>$base.'/api/v1/attendances','title'=>'Add Employee','format'=>'json','method'=>'post'],
                    

              ]
             ];
             $modules[] = $module;

          $module =[ 'item_type'=>'flat_list','name'=>'Attendance',

              'items'=>$modules
            ];

            
            $fmodules[] = $module;
    }

    public function addHRMModule2($item,&$fmodules){

        $app = App::getInstance();
        $base = $app->getBaseEndpoint();

          $modules = [];
         $val = $item->toArray();
        
        $val['name'] = [$val['first_name'],$val['last_name']];//,'uid'.$app->getAppUserId(),'perm'.$app->hasPermission($org,'manage_his')];
        $val['name']  =  implode(" ", $val['name']);

          $module = ['item_type'=>'post','data'=>['employee_id'=>$item->id],'module'=>'attendance','url'=>$base.'/api/v1/attendances','name'=>'Add Attendance'
,'title'=>'Add Attendance'
,'subtitle'=>$val['name']
          ,'format'=>'json','method'=>'post'];
            $modules[] = $module;

           $module =[  'item_type'=>'list','tenant_id'=>$item->id,'name'=>'Attendance Entries','list'=>$base.'/api/v1/employees','module'=>'user','edit_url2'=>$base.'/api/v1/attendances','barcode_enabled'=>false,

              'create2'=>[
                  ['tenant_id'=>$item->id,'module'=>'user','url'=>$base.'/api/v1/employees','title'=>'Add Employee','format'=>'json','method'=>'post'],
                    

              ]
             ];
             $modules[] = $module;

          $module =[ 'item_type'=>'flat_list','name'=>'Attendance',

              'items'=>$modules
            ];

            
            $fmodules[] = $module;
    }
}
