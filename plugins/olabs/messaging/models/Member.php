<?php

namespace Olabs\Messaging\Models;

use Model;

/**
 * Model
 */
class Member extends BaseModel {

    use \October\Rain\Database\Traits\Validation;

    const FIELD_USER_PHONE = 'contact_phone';
    const FIELD_USER_EMAIL = 'contact_email';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_messaging_users';

    /*
     * Register User Device for FCM messaging
     * Params : user_id, fcm_token, fcm_token_datetime, type, device_id
     * Type => android, ios
     */
    public $fillable = ['user_id', 'fcm_token', 'fcm_token_datetime', 'type', 'device_id', 'tenant_code', 'phone_no', 'email'];
    public $belongsTo = [
        'user' => [
            'Backend\Models\User',
            'key' => 'user_id',
        ],
    ];

    public static function register($params) {
//        $params = $params['data'];
        //check if user device already registered 
        $device_id = isset($params['device_id']) ? $params['device_id'] : '';
        $device_type = isset($params['type']) ? $params['type'] : '';
        $user_id = isset($params['user_id']) ? $params['user_id'] : '';
        $tenant_code = isset($params['tenant_code']) ? $params['tenant_code'] : '';

        $member = Member::where('user_id', $user_id)->where('tenant_code', $tenant_code)->first();

        if (!$member) {
            $member = new Member();
        }

        $member->fill($params);
        $member->status = 'L';
//        dd($params);
        $member->save();



        return $member->transformForApi();
    }

    public static function getMember($tenant_code, $user_id) {
        $member = Member::where('user_id', $user_id)->where('tenant_code', $tenant_code)->where('status', self::STATUS_LIVE)->first();

        return $member;
    }

    public function transformForApi() {
        $data = $this->toArray();


        return $data;
    }

    public function afterSave() {
        //$this->send();

        return parent::afterSave();
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
        $list = [];

//        $users = !is_array($users) ? [$users] : $users;

//        dd(count($users));
        foreach ($users as $user) {
//            dd($user->id);
//            dd($user instanceof \Backend\Models\User);
            if ($user instanceof Member) {
//                $user = Member::where('tenant_code', $tenant_code)->where('user_id', $user)->where('status', self::STATUS_LIVE)->first();
//                if ($user) {
                    $temp = [];

                    //iam
                    $temp['user_id'] = $user->user_id;

                    //sms
                    $temp['phone_no'] = $user->phone_no;

                    //email
                    $temp['email'] = $user->email;

                    //device
                    $temp['fcm_token'] = $user->fcm_token;

                    $list[] = $temp;
//                }
            }

            if ($user instanceof \Backend\Models\User) {
//                $user = \Backend\Models\User::where('id', $user)->first();
//                if ($user) {
                    $temp = [];

                    //iam
                    $user_id = $user->id;
                    $temp['user_id'] = $user_id;

                    //sms
                    $phone_nos = isset($user->{self::FIELD_USER_PHONE}) ? $user->{self::FIELD_USER_PHONE} : NULL;
                    $temp['phone_no'] = $phone_nos;

                    //email
                    $emails = isset($user->{self::FIELD_USER_EMAIL}) ? $user->{self::FIELD_USER_EMAIL} : NULL;
                    $temp['email'] = $emails;

                    //device
//                $user_devices = UserDevice::where('user_id', $user_id)->where('status', self::STATUS_LIVE)->list('username,fcm_token', 'device_id');
                    $user_devices_modal = UserDevice::where('user_id', $user_id)->where('status', self::STATUS_LIVE)->first();
                    $user_devices = $user_devices_modal ? $user_devices_modal->fcm_token : NULL;
                    $temp['fcm_token'] = $user_devices;

                    $list[] = $temp;
//                }
            }
        }

        return $list;
    }

    /**
      https://medium.com/@chahat.jain0/android-push-notifications-using-firebase-cloud-messaging-fcm-php-and-mysql-da571960aeba

      params:
      tenant: resure | other_app_id |....
      channel: FCM token for one 2 one | or group name -- group name must be prefixed with group_
      message : array , title|message should be mndatory
      example : ['title'=>'sample title','message'=>'sample message']
     * */
    public function send($tenant, $channel, $message) {

        //BaseModel::$feature_enabled = false;
        $servername = "localhost";


        $TENANTS = [
            'resure' => [
                'api_access_key' => "AAAA32EVr68:APA91bGeADkrW8g0V5SIKQrxhq1WwC2L4tW0DpTu8ElCvQOrDkFF6iHMpc1hdNx3XBDxmgla8nk_-hIUNbyvYnMzidqP3XScvO3GKfYOVAPQ4XPOD4t00rXlV-imR4_nQstPRV89Me4E"
            ],
            'opac' => [
                'api_access_key' => "AAAA32EVr68:APA91bGeADkrW8g0V5SIKQrxhq1WwC2L4tW0DpTu8ElCvQOrDkFF6iHMpc1hdNx3XBDxmgla8nk_-hIUNbyvYnMzidqP3XScvO3GKfYOVAPQ4XPOD4t00rXlV-imR4_nQstPRV89Me4E"
            ]
        ];


        $API_ACCESS_KEY = $TENANTS[$tenant]['api_access_key'];

        $registration_ids = false;

        if (!stripos($channel, "group_")) {
            # code...
            $registration_ids = [$channel];
        } else {
            //@todo: find all device tokens from DB
        }

        if (!$registration_ids) {
            return ['s' => '404', 'm' => 'no devices found'];
        }




        $fields = [
            'registration_ids' => [$channel],
            'data' => $message
        ];

        $headers = [
            'Authorization: key=' . $API_ACCESS_KEY,
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        return ['s' => '200', 'm' => 'message processed', 'result' => $result];
    }

}
