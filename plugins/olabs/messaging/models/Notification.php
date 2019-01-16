<?php

namespace Olabs\Messaging\Models;

use Model;
use DB;
use Lang;
use BackendAuth;

/**
 * Model
 */
class Notification extends BaseModel {

//    const STATUS_LIVE = 'L';
//    const FIELD_USER_PHONE = 'contact_phone';
//    const FIELD_USER_EMAIL = 'contact_email';
    
    const NOTIFICATION_TYPE_FCM = "fcm";
    const NOTIFICATION_TYPE_SMS = "sms";
    const NOTIFICATION_TYPE_EMAIL = "email";
    const NOTIFICATION_TYPE_WEB_PUSH = "web_push";
    const NOTIFICATION_TYPE_MOBILE_PUSH = "mobile_push";



    const CNAME = 'messaging_notification';

    public function getEntityType() {
        return self::CNAME;
    }
    
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    protected $jsonable = ['data'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_messaging_notifications';

    /*
     * Initilaizing notifications for sending from plugins
     */
    public function initialize($template_code, $params, $to_users, $from_user = NULL, $tenant_code = NULL){
        $tenant_code = $tenant_code != '' ? $tenant_code : $this->getSettingsTenantCode();
        
        
        $template = \Olabs\Messaging\Models\Template::getTemplate($template_code, $tenant_code);
        
        if(!$template){
            return true;
        }
        
        $notification = $template->bind_template($params);
        
        if(!count($notification)){
            return true;
        }
        
        $status = $this->send($notification, $to_users, $from_user, $tenant_code);
        
        return $status;
    }




    /*
     * Send notification 
     * PARAMS ::
     *  notification - as per generate notification template structure
     * [
     *      'web_push' => ['title'=> '', 'message' => ''],
     *      'sms' => ['title'=> '', 'message' => ''],
     *      'mobile_push' => ['title'=> '', 'message' => ''],
     *      'email' => ['title'=> '', 'message' => ''],
     * ]
     *  params - key, value attributes used in message templates
     *  to_users - uesr list either backend user object or id
     *  from_user - user
     */

    public function send($notification, $to_users, $from_user = NULL, $tenant_code = NULL) {

        //generate message
//        $notification = $this->generate_notification($template_code, $params);

        
        //get user list and their details
        $receivers = $this->user_details($to_users, $tenant_code);

//        dd($receivers);
        
        //get sender details
        if($from_user != ''){
            $senders = $this->user_details($from_user, $tenant_code);
        }
        

        //Send notification 
        $status = $this->push_notification(['notification' => $notification, 'to_users' => $receivers, 'from_users' => $senders], $tenant_code);
    }

    /*
     * Call Exchange api for sending notification
     * PRAMAS ::
     * notification ::: [
     *      'notification' => [
     *          'web_push' => ['title'=> '', 'message' => ''],
     *          'sms' => ['title'=> '', 'message' => ''],
     *          'mobile_push' => ['title'=> '', 'message' => ''],
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

    public function push_notification($notification, $tenant_code = NULL, $circle_code = NULL, $fcm_access_key = NULL, $api_call = False) {

        $data = [];
        $data['tenant_code'] = $tenant_code != '' ? $tenant_code : $this->getSettingsTenantCode();
        $data['fcm_access_key'] = $fcm_access_key != '' ? $fcm_access_key : $this->getSettingsFCMAccessKey();
        $data['data'] = $notification;
        $data['circle_code'] = $circle_code;

        //Notification send by api call 
        if ($api_call) {
            $messaging_api_url = $this->getSettingsMessaginApiUrl();
            $messaging_api_key = $this->getSettingsMessaginApiKey();


            $headers = [
                'Authorization: key=' . $messaging_api_key,
                'Content-Type: application/json'
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $messaging_api_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $result = curl_exec($ch);
            curl_close($ch);


            //@todo : save status in audit log if plugin available

            return ['s' => '200', 'm' => 'Message Processed.', 'result' => $result];
        }

        //Save notification in modal 
        $social_client = \Olabs\Social\Models\Clients::where('code',$data['tenant_code'])->where('status', self::STATUS_LIVE)->first();
        if(!$social_client){
            //throw exception
            throw new \Exception("Tenant not found.", 403);
        }
        $model = new Notification();
        $model->tenant_code = $data['tenant_code'];
        $model->tenant_id = $social_client->id;
        $model->fcm_access_key = $data['fcm_access_key'];
        $model->data = $data['data'];
        $model->circle_code = $data['circle_code'];
        $model->status = self::STATUS_LIVE;
        $model->save();

        //Call notification sending process
        $status = $model->process_pushed_notification();
        
        return $status;
    }

    /*
     * Process Notification
     * @todo : call this function in async process
     */

    public function process_pushed_notification($id = NULL) {

        $notification_modal = $this;
        
        //Generate Circle
        $circle = Circle::getCircle($notification_modal->tenant_code, $notification_modal->circle_code, '', $notification_modal->data['to_users']);

        if (!$circle) {
            //throw exception
        }


//        $circle_members = $circle->members;
        $notification = $notification_modal->data['notification'];
        $circle_members = $circle->getCircleMembers($circle->id);
//        dd(count($circle_members));

        //Process mobile_push Message
        if (isset($notification[self::NOTIFICATION_TYPE_MOBILE_PUSH])) {
            $title = $notification[self::NOTIFICATION_TYPE_MOBILE_PUSH]['title'];
            $message = $notification[self::NOTIFICATION_TYPE_MOBILE_PUSH]['message'];

//            $fcm_api_token = 
            //save in social notification for each member
            foreach ($circle_members as $member) {
                if ($member->fcm_token != '') {
                    $temp = [];
                    $temp['type'] = self::NOTIFICATION_TYPE_FCM;
                    $temp['title'] = $title;
                    $temp['message'] = $message;
                    $temp['fcm_token'] = $member->fcm_token;
                    
                    $social_notification = new \Olabs\Social\Models\Notifications();
                    $social_notification->tenant_id = $notification_modal->tenant_id;
                    $social_notification->data = [$temp];
                    $social_notification->notification_type = self::NOTIFICATION_TYPE_FCM;
                    $social_notification->entity_type = $notification_modal->getEntityType();
                    $social_notification->entity_id = $notification_modal->id;
//                    $social_notification->status = '100';
                    $social_notification->save();
//                    $social_notification->tenant_id = $notification_modal->tenant_id;
                    
                    
                }
            }
        }

        //Process SMS
        if (isset($notification[self::NOTIFICATION_TYPE_SMS])) {
            $title = $notification[self::NOTIFICATION_TYPE_SMS]['title'];
            $message = $notification[self::NOTIFICATION_TYPE_SMS]['message'];

//            $fcm_api_token = 
            //save in social notification for each member
            foreach ($circle_members as $member) {
                if ($member->phone_no != '') {
                    $temp = [];
                    $temp['type'] = self::NOTIFICATION_TYPE_SMS;
                    $temp['title'] = $title;
                    $temp['message'] = $message;
                    $temp['to'] = $member->phone_no;
                    
                    $social_notification = new \Olabs\Social\Models\Notifications();
                    $social_notification->tenant_id = $notification_modal->tenant_id;
                    $social_notification->data = [$temp];
                    $social_notification->notification_type = self::NOTIFICATION_TYPE_SMS;
                    $social_notification->entity_type = $notification_modal->getEntityType();
                    $social_notification->entity_id = $notification_modal->id;
//                    $social_notification->status = '100';
                    $social_notification->save();
//                    $social_notification->tenant_id = $notification_modal->tenant_id;
                    
                    
                }
            }
        }
        //Process eMail
        if (isset($notification[self::NOTIFICATION_TYPE_EMAIL])) {
            $title = $notification[self::NOTIFICATION_TYPE_EMAIL]['title'];
            $message = $notification[self::NOTIFICATION_TYPE_EMAIL]['message'];

//            $fcm_api_token = 
            //save in social notification for each member
            foreach ($circle_members as $member) {
                if ($member->email != '') {
                    $temp = [];
                    $temp['type'] = self::NOTIFICATION_TYPE_EMAIL;
                    $temp['title'] = $title;
                    $temp['message'] = $message;
                    $temp['to'] = $member->email;
                    
                    $social_notification = new \Olabs\Social\Models\Notifications();
                    $social_notification->tenant_id = $notification_modal->tenant_id;
                    $social_notification->data = [$temp];
                    $social_notification->notification_type = self::NOTIFICATION_TYPE_EMAIL;
                    $social_notification->entity_type = $notification_modal->getEntityType();
                    $social_notification->entity_id = $notification_modal->id;
//                    $social_notification->status = '100';
                    $social_notification->save();
//                    $social_notification->tenant_id = $notification_modal->tenant_id;
                    
                    
                }
            }
        }
        //Process Web Push
        if (isset($notification[self::NOTIFICATION_TYPE_WEB_PUSH])) {
            $title = $notification[self::NOTIFICATION_TYPE_WEB_PUSH]['title'];
            $message = $notification[self::NOTIFICATION_TYPE_WEB_PUSH]['message'];

//            $fcm_api_token = 
            //save in social notification for each member
            foreach ($circle_members as $member) {
                if ($member->user_id != '') {
                    $temp = [];
                    $temp['type'] = self::NOTIFICATION_TYPE_WEB_PUSH;
                    $temp['title'] = $title;
                    $temp['message'] = $message;
                    $temp['to'] = $member->user_id;
                    
                    $social_notification = new \Olabs\Social\Models\Notifications();
                    $social_notification->tenant_id = $notification_modal->tenant_id;
                    $social_notification->target_id = $member->user_id;
                    $social_notification->target_type = 'user';
                    $social_notification->data = [$temp];
                    $social_notification->notification_type = self::NOTIFICATION_TYPE_WEB_PUSH;
                    $social_notification->entity_type = $notification_modal->getEntityType();
                    $social_notification->entity_id = $notification_modal->id;
//                    $social_notification->status = '100';
                    $social_notification->save();
//                    $social_notification->tenant_id = $notification_modal->tenant_id;
                    
                    
                }
            }
        }
        
        return ['s'=>'200','m'=>'message processed'];
    }
    
    
    

    /*
     * Generate user details for notification
     * Structure ::
     * [
     *      [
     *          'user_id' => ['User ID'],
     *          'phone_no' => ['Phone No'],
     *          'email' => ['Email Id'],
     *          'fcm_token' => ['FCM Token'],
     *      ],
     * ]
     */

    public function user_details($users, $tenant_code) {
        
        $member = new Member();
        return $member->user_details($users, $tenant_code);
        
        
        //Below code is not in use

//        $list = [];
//
//        $users = !is_array($users) ? [$users] : $users;
//
//        foreach ($users as $user) {
//            if (!$user instanceof \Backend\Models\User) {
//                $user = \Backend\Models\User::where('id', $user)->first();
//            }
//
//            if ($user) {
//                $temp = [];
//
//                //iam
//                $user_id = $user->id;
//                $temp['user_id'] = $user_id;
//
//                //sms
//                $phone_nos = isset($user->{self::FIELD_USER_PHONE}) ? $user->{self::FIELD_USER_PHONE} : NULL;
//                $temp['phone_no'] = $phone_nos;
//
//                //email
//                $emails = isset($user->{self::FIELD_USER_EMAIL}) ? $user->{self::FIELD_USER_EMAIL} : NULL;
//                $temp['email'] = $emails;
//
//                //device
////                $user_devices = UserDevice::where('user_id', $user_id)->where('status', self::STATUS_LIVE)->list('username,fcm_token', 'device_id');
//                $user_devices_modal = UserDevice::where('user_id', $user_id)->where('status', self::STATUS_LIVE)->first();
//                $user_devices = $user_devices_modal ? $user_devices_modal->fcm_token : NULL;
//                $temp['fcm_token'] = $user_devices;
//
//                $list[] = $temp;
//            }
//        }
//
//        return $list;
    }

    

}
