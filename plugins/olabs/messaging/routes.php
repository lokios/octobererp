<?php

/*
 * Register User Device for FCM messaging
 * Params : user_id, fcm_token, fcm_token_datetime, type, device_id, tenant_code
 * Type => android, ios
 */

//Route::post('messaging/api/v2/userdevice_register', function (Request $request) {
//    //BaseModel::$feature_enabled = false;
//    $params = $request->json()->all(); //Input::all();
//    //return $params;
//    $user = false;
//
//    $dataSource = \Olabs\Messaging\Models\UserDevice::register($params);
//    return $dataSource;
//});


Route::any('messaging/api/v2/member_register/{tenant}/{user_id}/{type}/{token}/{phone_no}/{email}', function ($tenant, $user_id, $type, $token, $phone_no, $email) {
    //BaseModel::$feature_enabled = false;
//    $params = $request->json()->all(); //Input::all();
    //return $params;
    $user = false;
    $params = [
        'user_id' => $user_id,
        'fcm_token' => $token,
        'tenant_code' => $tenant,
        'type' => $type,
        'phone_no' => $phone_no,
        'email' => $email,
    ];
//    dd($params);
    $dataSource = \Olabs\Messaging\Models\Member::register($params);
    return $dataSource;
});


/*
 * Register circle for the the tenant
 * 
 */
Route::any('messaging/api/v2/circle_register/{tenant}/{code}/{title}', function ($tenant, $code, $title) {

    $dataSource = \Olabs\Messaging\Models\Circle::getCircle($tenant, $code, $title);
    return $dataSource->transformForApi();
});


/*
 * Add member to circle
 * 
 */
Route::any('messaging/api/v2/circle_member_add/{tenant}/{code}/{user_id}', function ($tenant, $code, $user_id) {

    $circle = \Olabs\Messaging\Models\Circle::getCircle($tenant, $code);
    
    $member = Olabs\Messaging\Models\Member::getMember($tenant, $user_id);
    $circle->addMember($member->transformForApi());
    
    return $circle->transformForApi();
});


/*
 * Remove member to circle
 * 
 */
Route::any('messaging/api/v2/circle_member_remove/{tenant}/{code}/{user_id}', function ($tenant, $code, $user_id) {

    $circle = \Olabs\Messaging\Models\Circle::getCircle($tenant, $code);
    
    $member = Olabs\Messaging\Models\Member::getMember($tenant, $user_id);
    $circle->removeMember($user_id);
    
    return $circle->transformForApi();
});





/*
 * Notification Types : type = fcm, sms, email, iam, all
 * Entity Type : circle, user
 * Entity Id : circle code or user id
 * 
 * Call Exchange api for sending notification
 * PRAMAS ::
 * notification ::: 
 * [
 *      'notification' => [
 *          'iam' => ['title'=> '', 'message' => ''],
 *          'sms' => ['title'=> '', 'message' => ''],
 *          'fcm' => ['title'=> '', 'message' => ''],
 *          'email' => ['title'=> '', 'message' => ''],
 *      ], 
 *      'to_users' => [
 *          [
 *              'user_id' => ['User ID'],
 *              'phone_no' => ['Phone No'],
 *              'email' => ['Email Id'],
 *              'fcm_token' => ['FCM Token'],
 *          ],
 *      ], 
 *      'from_users' => [
 *          [
 *              'user_id' => ['User ID'],
 *              'phone_no' => ['Phone No'],
 *              'email' => ['Email Id'],
 *              'fcm_token' => ['FCM Token'],
 *          ],
 *      ]
 *  ]
 * tenant_code : if not found then load form settings
 * fcm_access_key : if not found then load from settings
 * circle_code : if not send then system will generate unique
 * 
 */

Route::any('messaging/api/v2/push/{tenant}/{notification_type}/{entity_type}/{entity_id}/{title}/{message}', function ($tenant, $notification_type, $entity_type, $entity_id, $title, $message) {
    //BaseModel::$feature_enabled = false;
    
    $notification =  [
           $notification_type => ['title'=> $title, 'message' => $message],
//           'fcm' => ['title'=> $title, 'message' => $message],
//           'sms' => ['title'=> '', 'message' => ''],
//           'email' => ['title'=> '', 'message' => ''],
//           'iam' => ['title'=> '', 'message' => ''],
      ];
    
    

    $pushService = new \Olabs\Messaging\Models\Notification();
    $circle_code = NULL;
    $receivers = NULL;
    
    if($entity_type == 'user'){
        $receivers = $pushService->user_details($tenant, $entity_id);
    }else if( $entity_type == 'circle'){
        $circle_code = $entity_id;
    }
    
    $senders=null;
    
    $data = ['notification' => $notification, 'to_users' => $receivers, 'from_users' => $senders];
    
    $status = $pushService->push_notification($data, $tenant, $circle_code);
    return $status;
});






/**

  send one 2 one messaging test
  http://dev.login.resure.octobererp.com/insurance/api/v2/push/{tenant}/{channel}/{title}/{message}
  http://dev.login.resure.octobererp.com/insurance/api/v2/push/resure/test_token/hell1/hello2


 * */
//Route::any('messaging/api/v2/push/{tenant}/{channel}/{title}/{message}', function ($tenant, $channel, $title, $message) {
//    //BaseModel::$feature_enabled = false;
//    $servername = "localhost";
//
//    $token = $channel;
//    if ($token == 'test_token') {
//
//        $token = "d3VGYxcbfxw:APA91bH1zw-sJ_NbkxbSFvZ6zjxTrEvgIa7LmP3iKRTBvOrnhVhiIpd4ICejoh86Tbhl-ldcG8lET6iGZjGPz5WA3xDEL1c6lHGkPfCjckGsy-2bo_Z-WF2Jtsm6kU_C1Udzq5p_qvXJ";
//    }
//
//    $msgData = [
//                'message' => $message,
//                'title' => $title
//    ];
//
//    $pushService = new \Olabs\Messaging\Models\UserDevice();
//    $status = $pushService->send($tenant, $token, $msgData);
//    return $status;
//});
