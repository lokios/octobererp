<?php
namespace Olabs\App\Classes;

use Model;

use BackendAuth;
use Backend;
use Config;
use Event;
use Cache;
use Request;


use Flash;
use Olabs\Tenant\Models\Organizations;
use Olabs\Tenant\Models\Profiles;
use Olabs\Tenant\Models\BaseModel;
use League\Fractal\TransformerAbstract;

use OlabsAuth;

class App extends TransformerAbstract{

    public $profile;
    public $user_id;

    public $val;

    public static function getInstance(){
        return new App();
    }

    public function getAppId(){

        $params = getallheaders() ;

        if (!empty($params['app_id']) ) {
             return $params['app_id'];
       }

       if (!empty($_GET['app_id']) ) {
             return $_GET['app_id'];
       }

    }

    public function getAppUserId(){

        // $value = Request::header('user_id');
        $params = getallheaders() ;

        if (!empty($params['user_id']) && is_numeric($params['user_id'])) {
            return $params['user_id'];
       }

       if (!empty($_GET['app_user_id']) ) {
             return $_GET['app_user_id'];
       }

    }

     public function getAppUser(){

        if($this->user){
          return $this->user;
        }

        $user_id = self::getAppUserId();
        $user = OlabsAuth::findUserById($user_id);
        if($user)
        OlabsAuth::login($user);

        $this->user = $user;

        return $user;

    }

    public function getAppUserProfile(){

        $user_id = $this->getAppUserId();

        if(!$user_id)return false;
        $profile = Profiles::getProfileByUserId($user_id);

        return $profile;

    }

    public function getAppUserProfileByOrg($org){

        $user_id = $this->getAppUserId();

        if(!$user_id)return false;
        $profile = Profiles::getProfileByUserIdAndOrg($user_id,$org);

        return $profile;

    }

    public function  getBaseEndpoint(){

        //$url =  'http://opaclabs.com/'.$this->getAppId();

        if($this->getAppId()=='vss'){
            //$url =  'http://oimsapp.opaclabs.com';

            return Config::get('olabs.tenant::app_url', 'http://oimsapp.opaclabs.com');

            return $url;
        }
        
        return Config::get('olabs.tenant::app_url', 'http://opaclabs.com');
        //$url =  'http://opaclabs.com';

        //return $url;
    }

    public function  getBaseEndpointImages(){
        return Config::get('olabs.tenant::app_images_url', 'http://opaclabs.com');
        //$url =  'http://opaclabs.com';

        return $url;
    }


    public function hasPermission($org,$permission){


        if($this->getAppId()=='vss'){
            return true;
        }

        //return true;
        $allowed = false;

        $sessionProfile = $this->getAppUserProfileByOrg($org);

        if($sessionProfile){
           // return "yes";
        }

        BaseModel::$feature_enabled = false;
        if($sessionProfile && $sessionProfile->isTenantAdmin()){
            return true;
        }


        return $allowed;

    }


    ///////// Generic methods ///////////////
function get_class_name($classname)
{
    if ($pos = strrpos($classname, '\\')) return substr($classname, $pos + 1);
    return $pos;
}



   public  function getProps(){

        return [];

    } 

 public function getImageMain($fi){


        //return $fi->path;
        return $fi->getThumb(480, 'auto', ['mode' => 'landscape']);


    }

 public $images_field = false;
 public $item;
 public function getImagesApi($size=null,$default=null){
        //$model->avatar->getThumb(100, 100, ['mode' => 'crop']);

         $images = [];
        if(!$size)$size='thumb';

         if(!$this->images_field)return $images;
        if($this->item->{$this->images_field}){

            foreach($this->item->{$this->images_field} as $fi){

               $images[] = ['uri'=>$this->getImageMain($fi),'id'=>$fi->id];
            }
        }

        //return '/themes/octobererp_theme1/assets/images/default_about.jpg';

        return $images;
    }

    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform( $item)
    {

        $this->item = $item;

        $app = App::getInstance();

        $base = $app->getBaseEndpoint();
       
        //$org = Organizations::where(['id'=>$item->tenant_id])->first();

        $val = $item->toArray();

        $props = $this->getProps();
        foreach ($props as $key => $value) {
            # code...
            $val[$key] = $value;
        }

        if(isset($val['name'])){
           $val['name'] = [$val['name']];//,'uid'.$app->getAppUserId(),'perm'.$app->hasPermission($org,'manage_his')];
        }

        if(isset($val['title'])){
           $val['name'] = [$val['title']];//,'uid'.$app->getAppUserId(),'perm'.$app->hasPermission($org,'manage_his')];
        }

        if(isset($val['first_name'])){
           $val['name'] = [$val['first_name'],$val['last_name']];//,'uid'.$app->getAppUserId(),'perm'.$app->hasPermission($org,'manage_his')];
        }

        if(!isset($val['content_type'])){
           $val['content_type'] = $this->get_class_name(get_class($item));
           $val['content_type'] = strtolower( $val['content_type'] );
         }

       if(isset($val['name'])){

             $val['name']  =  implode(" ", $val['name']);

         }

         $val['images'] = $this->getImagesApi();

         if($val['images'] && count($val['images'])>0){
              $val['main_image'] = $val['images'][0]['uri'];
 
     }
         /*if($this->getAppId()!='vss'){
        $val['images'] = $item->getImagesApi();

        
        $img = $item->getImage('lg',null);

        $val['bg_image'] = $img?$img:$app->getBaseEndpointImages().'/themes/octobererp_theme1/assets/images/'.$org->getDomainCode().'/default_services.jpg';
         $val['main_image'] = $img?$img:$app->getBaseEndpointImages().'/themes/octobererp_theme1/assets/images/'.$org->getDomainCode().'/default_about.jpg';

     }
*/

         $this->val = $val;


         return $val;


     }


/**
     public function getAspect(){
        $aspects = [];
        $aspect = ['name'=>'Asset','names'=>'Assets', 'package'=>'oims'
           ,'operations'=>['create'=>['context'=>['tenant_id','project_id'],'perm'=>['tenant_admin']]
               ,'edit'=>['perm'=>['tenant_admin']]
               ,'list'=>['perm'=>['@']]
               ]
        ];
        $aspects['oims.asset'] = $aspect;


        $aspect = ['name'=>'Asset Monitor Entry','names'=>'Assets Monitor Entries', 'package'=>'oims'
           ,'operations'=>['create'=>['context'=>['tenant_id','project_id'],'perm'=>['tenant_admin']
           'form'=>['product_id'=>['ui_type'=>'autocomplete','content_type'=>'product','barcode'=>'Y']]
             
           ]
               ,'edit'=>['perm'=>['tenant_admin']]
               ,'list'=>['filters'=>['product_id','created_at'],'perm'=>['@']],
               ]
        ];
        $aspects['oims.asset_monitor_entry'] = $aspect;


        
        $aspect = ['name'=>'Booking','names'=>'Bookings', 'package'=>'appoint'
           ,'operations'=>['create'=>['context'=>['tenant_id','services_id'],'perm'=>['tenant_admin']
           'form'=>['services_id'=>['ui_type'=>'autocomplete','content_type'=>'product','barcode'=>'Y']]
             
           ]
               ,'edit'=>['perm'=>['tenant_admin']]
               ,'list'=>['filters'=>['product_id','created_at'],'perm'=>['@']],
               ]
        ];
        $aspects['appoint.booking'] = $aspect;



     }

     public function getAspectByContext($id, $context){
        $aspect = $this->getAspect($id);

        if(!$aspect)return false;

        if(isset($aspect['operations']['list'])){
            $aspect['list_url'] =  $base.'/'.$aspect['package'].'/api/v1'.$apect['module'].'?';
            if($context){
                 $aspect['list_url'] .= http_build_query($context);
            }


        }


     }**/




public function addMainModules(&$fmodules){

    if($this->getAppId()=='vss'){
        $this->addMainModules_OIMS($fmodules);
    }


}

public $user;
public function addMainModules_OIMS(&$fmodules){


        $app =$this;
        $base = $app->getBaseEndpoint();

          $modules = [];

          if($this->user){

            $userModel = new \Olabs\Oimsapi\Http\Transformers\EmployeeTransformer();
            $userModel = $userModel->transform($this->user);
          $module = ['item_type'=>'group'
          ,'data'=>[]
          ,'module'=>'user','name'=>'Welcome '.$app->user->first_name.' '.$app->user->last_name
          ,'title'=>'My Profile','content'=>$userModel
          ,'subtitle'=>$app->user->first_name.' '.$app->user->last_name
          ,'format'=>'json','method'=>'post'];

          $fmodules[] = $module;

        }

          if($this->hasTimesheetManagePermission()){

          $module = ['item_type'=>'post'
          ,'data'=>[]
          ,'module'=>'attendance','url'=>$base.'/api/v1/attendances','edit_url'=>$base.'/api/v1/attendances','name'=>'Add Attendance'
          ,'title'=>'Add Attendance'
          ,'subtitle'=>''
          ,'format'=>'json','method'=>'post'];
            $fmodules[] = $module;

           $module =[  'item_type'=>'list','name'=>'Recent Attendance Entries','list'=>$base.'/social/api/v1/entityrelations?target_type=attendance&actor_id='.$app->user->id,'module'=>'user','edit_url2'=>$base.'/social/api/v1/entityrelations?target_type=attendance&actor_id='.$app->user->id,'barcode_enabled'=>false,

             
             ];
             $fmodules[] = $module;

           }


          if($this->hasMREntryCreatePermission()){

             $module = ['item_type'=>'post'
          ,'data'=>[]
          ,'module'=>'mr_entry','url'=>$base.'/social/api/v1/entityrelations'
          ,'edit_url'=>$base.'/api/v1/entityrelations'
          ,'upload_url'=>$base.'/social/api/v1/entityrelations/upload'
          ,'name'=>'Add MR Entry'
          ,'title'=>'Add MR Entry'
          ,'subtitle'=>''
          ,'format'=>'json','method'=>'post'];


          if($this->hasMREntryCreatePermission()){
             $module['form_id'] = 'mr_entry_backdate';

          }



            $fmodules[] = $module;

           $module =[  'item_type'=>'list','name'=>'Recent MR Entries','list'=>$base.'/social/api/v1/entityrelations?target_type=mr_entry&actor_id='.$app->user->id,'module'=>'mr_entry','edit_url2'=>$base.'/api/v1/entityrelations','barcode_enabled'=>false,

             
             ];
             $fmodules[] = $module;

           }

         
    }

    public function hasTimesheetManagePermission(){

      //olabs.oims.attendances

      if ($this->user->hasPermission([
         'olabs.oims.attendances',
         //'acme.blog.access_categories'
   ])) 

      return true;
    }

    public function hasMREntryCreatePermission(){
       if ($this->user->hasPermission([
         'olabs.oims.purchases',
         //'acme.blog.access_categories'
   ])) 

      return true;
    }

     public function hasMREntryCreateWithBackdatePermission(){
       if ($this->user->hasPermission([
         'olabs.oims.record_approvals',
         //'acme.blog.access_categories'
   ])) 

      return true;
    }


    public function getSessionData(){

        $user1 = $this->getAppUser();
        $user = $user1;
       
     
     BaseModel::$feature_enabled = true; 

     $user = ['id'=>$user->id,'first_name'=>$user->first_name,'last_name'=>$user->last_name,'login'=>$user->login, 'email'=>$user->email,'phone'=>$user->contact_phone,'type'=>'otp'];

     $app = $this;
     

     if($app->getAppId()=='vss'){

      //$base = 'http://oimsapp.opaclabs.com';
      
       $base = $app->getBaseEndpoint();


        $main_modules = [];
        $app->addMainModules($main_modules);

      
    $modules = [];
    $modules['my_organizations'] = [
   'module'=>'my_organizations','list'=>$base.'/api/v1/projects',
       'is_paid'=>'Y','gproduct_id'=>'demo','balance'=>0,'edit_url'=>$base.'/api/v1/projects'
  

    ];

    $service_types = [
       'for_enquiry'=>'For Enquiry',
       'for_scheduled_appointment'=>'For Appointment',
       'for_sale'=>'For Sale',
      
    ];

    $module['service_types'] = $service_types;
    //$modules = json_decode($modules,true);
    $user['modules'] = $modules;


     $status = ['version'=>'1.0', 'base'=>Config::get('olabs.tenant::app_url', 'http://opaclabs.com'),'s'=>'200','user'=>$user, 'groups'=>$user1->groups,'app_settings'=>[]];//, 'my_organizations'=>$list];

      $projects = [];
      if (!$user1->isAdmin()) {
//            foreach ($user->projects as $project) {
//                $list[$project->id] = $project->name;
//            }
            $list = $user1->projects;
        } else {
            $list = \Olabs\Oims\Models\Project::where([])->get();
        }
      foreach ($list as $key => $value) {
        # code...
        $projects[$value->id.''] = $value->name;
      }

      $status['app_settings']['projects'] = $projects;

      $featured = [];
      foreach ($list as $key => $value) {
        # code...
        $model = new \Olabs\Oimsapi\Http\Transformers\ProjectTransformer();
            $project = $model->transform($value);
            $featured[] = $project;
      }
      $status['app_settings']['featured'] = $featured;
      $status['app_settings']['main_modules'] = $main_modules;

    

      return $status ;

     }


     if($app->getAppId()=='medihubplus'){

     
    $modules = [];
    $modules['my_organizations'] = [
   'module'=>'my_organizations','list'=>'http://opaclabs.com/tenant/api/v1/'.$user1->id.'/organizations','add_permission'=>'paid_product',
       'is_paid'=>'Y','gproduct_id'=>'demo','balance'=>0,'edit_url'=>'http://opaclabs.com/tenant/api/v1/organizations'
  

    ];
    //$modules = json_decode($modules,true);
    $user['modules'] = $modules;

  }


    $status = ['s'=>'200','user'=>$user, 'groups'=>$user1->groups];//, 'my_organizations'=>$list];




    

    return $status ;

    }



}