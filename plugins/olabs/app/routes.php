<?php

use Illuminate\Http\Request;

use Backend\Models\User as BackendUser;

//use Olabs\Oims\Models\Employee;

use Olabs\Tenant\Models\BaseModel;
use Olabs\App\Classes\App;
use Olabs\Oims\Models\Project;
//use Olabs\App\Classes\App;


Route::group(['prefix' => 'app/api/v1'], function () {

 Route::get('resource/{content_type}', 'Olabs\App\Http\Controllers\Contents@indexByContentType');
 Route::post('resource/{content_type}', 'Olabs\App\Http\Controllers\Contents@storeByContentType');
 Route::put('resource/{content_type}', 'Olabs\App\Http\Controllers\Contents@updateByContentType');
 Route::post('resource/{content_type}/upload', 'Olabs\App\Http\Controllers\Contents@uploadByContentType');
 //Route::resource('resource/{content_type}', 'Olabs\App\Http\Controllers\Contents');
    
});

Route::group(['prefix' => 'api/v1'], function () {

 Route::post('events/upload', 'Olabs\App\Http\Controllers\Events@upload');
 Route::post('profiles/upload', 'Olabs\App\Http\Controllers\Profiles@upload');
  Route::post('profiles', 'Olabs\App\Http\Controllers\Profiles@store');  
   Route::put('profiles/{id}', 'Olabs\App\Http\Controllers\Profiles@update');  
 Route::resource('events', 'Olabs\App\Http\Controllers\Events');
 Route::resource('profiles', 'Olabs\App\Http\Controllers\Profiles');       
});

/**
 * curl --data "param1=value1&param2=value2" https://example.com/resource.cgi

 curl --data "login=admin&password=mkb@123!" http://opaclabs.com/a/signin

 */
Route::any('app/api/v1/settings/refresh', function () {
        BaseModel::$feature_enabled = false;
        $data = Input::all();
        $user = false;

        

     
     
     $app = App::getInstance();
     $user1 = $app->getAppUser();
     if(!$user1)return ['s'=>'403'];

     $app->user = $user1;

     return $app->getSessionData();
     
     BaseModel::$feature_enabled = true; 

     $user = ['id'=>$user->id,'first_name'=>$user->first_name,'last_name'=>$user->last_name,'login'=>$user->login, 'email'=>$user->email,'phone'=>$user->contact_phone,'type'=>'otp'];

     
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
      $list = Project::where([])->get();
      foreach ($list as $key => $value) {
        # code...
        $projects[$value->id.''] = $value->name;
      }

      $status['app_settings']['projects'] = $projects;
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
});





