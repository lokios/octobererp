<?php

use Illuminate\Http\Request;

use Backend\Models\User as BackendUser;

//use Olabs\Oims\Models\Employee;

use Olabs\Tenant\Models\BaseModel;
use Olabs\App\Classes\App;
use Olabs\Oims\Models\Project;
//use Olabs\App\Classes\App;

Route::group(['prefix' => 'api/v1'], function () {

       
      ///  Route::get('employees/{org?}/{project_id?}', 'Olabs\Oimsapi\Http\Controllers\Employees@search');
       // Route::get('suppliers/{org?}/{project_id?}', 'Olabs\Oimsapi\Http\Controllers\Suppliers@search');
        Route::resource('attendances', 'Olabs\Oimsapi\Http\Controllers\Attendances');

       // Route::get('offroleemployees', 'Olabs\Oimsapi\Http\Controllers\OffroleEmployees@search');
       // Route::get('offroleemployees/{org}', 'Olabs\Oimsapi\Http\Controllers\OffroleEmployees@search');
       // Route::get('offroleemployees/{org}/{project_id}', 'Olabs\Oimsapi\Http\Controllers\OffroleEmployees@search');


 Route::get('products/echo', 'Olabs\Oimsapi\Http\Controllers\Products@echo');
 Route::post('product/upload', 'Olabs\Oimsapi\Http\Controllers\Products@upload');
 Route::post('projectassetmonitor/upload', 'Olabs\Oimsapi\Http\Controllers\ProjectAssetMonitors@upload');
 Route::post('projectassettransfer/upload', 'Olabs\Oimsapi\Http\Controllers\ProjectAssetTransfers@upload');
 Route::post('projectassetdamage/upload', 'Olabs\Oimsapi\Http\Controllers\ProjectAssetDamages@upload');

 Route::get('projectassetmonitors/report', 'Olabs\Oimsapi\Http\Controllers\ProjectAssetMonitors@report');
 Route::get('projectassettransfers/report', 'Olabs\Oimsapi\Http\Controllers\ProjectAssetTransfers@report');
 Route::get('projectassetdamages/report', 'Olabs\Oimsapi\Http\Controllers\ProjectAssetDamages@report');
 Route::get('projectassets/report', 'Olabs\Oimsapi\Http\Controllers\ProjectAssets@report');

 
 Route::resource('products', 'Olabs\Oimsapi\Http\Controllers\Products');
 Route::resource('projectassets', 'Olabs\Oimsapi\Http\Controllers\ProjectAssets');
 Route::resource('projectassetmonitors', 'Olabs\Oimsapi\Http\Controllers\ProjectAssetMonitors');
 Route::resource('projectassettransfers', 'Olabs\Oimsapi\Http\Controllers\ProjectAssetTransfers');
 Route::resource('projectassetdamages', 'Olabs\Oimsapi\Http\Controllers\ProjectAssetDamages');


Route::resource('projects', 'Olabs\Oimsapi\Http\Controllers\Projects');
Route::resource('suppliers', 'Olabs\Oimsapi\Http\Controllers\Suppliers');
Route::resource('employees', 'Olabs\Oimsapi\Http\Controllers\Employees');
Route::resource('attendances', 'Olabs\Oimsapi\Http\Controllers\Attendances');
Route::resource('offroleemployees', 'Olabs\Oimsapi\Http\Controllers\OffroleEmployees');



Route::get('{org}/users', 'Olabs\Ehr\Http\Controllers\Users@indexByTenant');

Route::post('{tenant_id}/{user_id}/visits', 'Olabs\Ehr\Http\Controllers\WorkflowInstances@storeByUser');
Route::get('{user_id}/visits', 'Olabs\Ehr\Http\Controllers\WorkflowInstances@indexByUser');
Route::resource('visits', 'Olabs\Ehr\Http\Controllers\WorkflowInstances');

    
});



/**
 * curl --data "param1=value1&param2=value2" https://example.com/resource.cgi

 curl --data "login=admin&password=m***" http://opaclabs.com/a/signin

 */
Route::post('a/signin', function () {
        BaseModel::$feature_enabled = false;
        $data = Input::all();
        $user = false;

        //return $data;

        if(isset($data['type']) && $data['type']=='otp'){

             $q = $data['phone'];
             $q = str_ireplace("+", "", $q);
             $q = str_ireplace("-", "", $q);
             $q = str_ireplace(" ", "", $q);
             $q = substr($q, -10);

             //$q = '9958202825';



             $user = BackendUser::where([])->where('contact_phone', 'like', '%'.$q)->first();
             //if (!$user = OlabsAuth::findUserByLogin($data['phone'])) {
             if (!$user ) {   
                //throw new ApplicationException('Sorry, I don\'t recognize that email');
               // $data['password'] = 'opac@123!';
               // $profileService =  new Profiles();
                //$user = $profileService->createUser($data);
            }

            if(!$user){
                return ['s'=>'404'];
            }

            BackendAuth::login($user);

        }else{


        $rules = [
            'login'    => 'required|between:2,255',
            'password' => 'required|between:4,255'
        ];

        $validation = Validator::make(post(), $rules);
        if ($validation->fails()) {
            //throw new ValidationException($validation);
            return ['s'=>'403'];
        }

        // Authenticate user
        $user = BackendAuth::authenticate([
            'login' => post('login'),
            'password' => post('password')
        ], true);

    }


     $user1 = $user;
     
     BaseModel::$feature_enabled = true; 

     $user = ['id'=>$user->id,'first_name'=>$user->first_name,'last_name'=>$user->last_name,'login'=>$user->login, 'email'=>$user->email,'phone'=>$user->contact_phone,'type'=>'otp'];

     $app = App::getInstance();

     if($app->getAppId()=='vss'){

      //$base = 'http://oimsapp.opaclabs.com';
      $app = App::getInstance();
       $base = $app->getBaseEndpoint();

      
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
      $list = Project::where([])->get();
      foreach ($list as $key => $value) {
        # code...
        $projects[$value->id.''] = $value->name;
      }

      $status['app_settings']['projects'] = $projects;
    

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
});

