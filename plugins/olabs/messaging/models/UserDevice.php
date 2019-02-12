<?php

namespace Olabs\Messaging\Models;

use Model;

/**
 * Model
 */
class UserDevice extends Model {

    use \October\Rain\Database\Traits\Validation;

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_messaging_user_devices';

    /*
     * Register User Device for FCM messaging
     * Params : user_id, fcm_token, fcm_token_datetime, type, device_id
     * Type => android, ios
     */
    public $fillable = ['user_id', 'fcm_token', 'fcm_token_datetime', 'type', 'device_id'];
    public $belongsTo = [
        'user' => [
            'Backend\Models\User',
            'key' => 'user_id',
        ],
    ];

    public static function register($params) {
        $params = $params['data'];


        //check if user device already registered 
        $device_id = isset($params['device_id']) ? $params['device_id'] : '';
        $device_type = isset($params['type']) ? $params['type'] : '';
        $user_id = isset($params['user_id']) ? $params['user_id'] : '';

        $device = UserDevice::where(['user_id' => $user_id])->where(['type' => $device_type])->first();

        if (!$device) {
            $device = new UserDevice();
        }

        $device->fill($params);
        $device->status = 'L';
//        dd($params);
        $device->save();



        return $device->transformForApi();
    }

    public function transformForApi() {
        $data = $this->toArray();


        return $data;
    }

    public  function afterSave(){
        //$this->send();

        return parent::afterSave();
    }

    /**
         https://medium.com/@chahat.jain0/android-push-notifications-using-firebase-cloud-messaging-fcm-php-and-mysql-da571960aeba

         params:
           tenant: resure | other_app_id |....
           channel: FCM token for one 2 one | or group name -- group name must be prefixed with group_
           message : array , title|message should be mndatory
                   example : ['title'=>'sample title','message'=>'sample message']
    **/
    public function send($tenant,$channel,$message){

        //BaseModel::$feature_enabled = false;
         $servername = "localhost";
         

         $TENANTS = [
            'resure'=>[
              'api_access_key'=> "AAAA32EVr68:APA91bGeADkrW8g0V5SIKQrxhq1WwC2L4tW0DpTu8ElCvQOrDkFF6iHMpc1hdNx3XBDxmgla8nk_-hIUNbyvYnMzidqP3XScvO3GKfYOVAPQ4XPOD4t00rXlV-imR4_nQstPRV89Me4E"
            ],
            'opac'=>[
              'api_access_key'=> "AAAA32EVr68:APA91bGeADkrW8g0V5SIKQrxhq1WwC2L4tW0DpTu8ElCvQOrDkFF6iHMpc1hdNx3XBDxmgla8nk_-hIUNbyvYnMzidqP3XScvO3GKfYOVAPQ4XPOD4t00rXlV-imR4_nQstPRV89Me4E"
            ]
         ];


         $API_ACCESS_KEY = $TENANTS[$tenant]['api_access_key'];

         $registration_ids = false;

         if (!stripos($channel, "group_")) {
             # code...
             $registration_ids = [$channel];
         }else{
            //@todo: find all device tokens from DB
         }

         if(!$registration_ids ){
            return ['s'=>'404','m'=>'no devices found'];
         }
        
          
         
         
         $fields = 
         [
            'registration_ids'  => [$channel],
            'data'      => $message
         ];
         
         $headers = 
         [
           'Authorization: key=' . $API_ACCESS_KEY,
           'Content-Type: application/json'
         ];
         $ch = curl_init();
         curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
         curl_setopt( $ch,CURLOPT_POST, true );
         curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
         curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
         curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
         curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
         $result = curl_exec($ch );
         curl_close( $ch );

         return ['s'=>'200','m'=>'message processed','result'=>$result];

        
    }

}
