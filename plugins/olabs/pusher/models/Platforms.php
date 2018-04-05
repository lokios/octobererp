<?php namespace Olabs\Pusher\Models;

use Model;

/**
 * Model
 */
class Platforms extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
    ];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_pusher_platforms';


   public static  function test($r) {

        $o = \Olabs\Pusher\Models\Platforms::where([])->get();
        $list =[];
        foreach($o as $oi){
            $list[] = $oi->reg_id;
        }

       $service = new \Olabs\Pusher\Models\Platforms();
        $status = $service->pushGCM('school_engage',$list, array('title'=>'Test title','message'=>'Test Message','action'=>'Testing.'));

        return array('r'=>$r, 'data'=>$o,'status'=>$status);
    }


    public static function register($r) {

        $o = \Olabs\Pusher\Models\Platforms::where(['device_id'=>$r['device_id']])->first();
        if(!$o){
            $o = new \Olabs\Pusher\Models\Platforms();
            $o->reg_id = $r['reg_id'];
            $o->device_id = $r['device_id'];
            $o->app_id = $r['app_id'];
            $o->device_type = 'gcm';
            $o->save();
        }

        return array('r'=>$r, 'data'=>$o);
    }



    // private

    /**
     * Sending Push Notification
     * Enter description here ...
     * @param unknown_type $registatoin_ids could be comma separted device ids , message should be array
     * @param unknown_type $message

    invalid reg ids : responses:
    {"multicast_id":7060500398956114879,"success":0,"failure":1,"canonical_ids":0,"results":[{"error":"InvalidRegistration"}]}
     *
     */
    function pushGCM($tenant,$registatoin_ids, $message) {
        // include config
        //include_once './config.php';

        /*$googleSettings = AppSettings::getSettingPushGCM($tenant);
        if(!$googleSettings ||!isset($googleSettings->data['value']) ||!$googleSettings->data['value']){
            return array('s'=>'400',  'msg' => 'No settings found for PushGCM'   );
        }
        //$GOOGLE_API_KEY = Yii::app()->params['push'][$tenant]['GOOGLE_API_KEY'];
        $GOOGLE_API_KEY = $googleSettings->data['value'];*/

        $data = array('school_engage'=>'AIzaSyBVAvFtQfQBL8RwMbtnL25vGf02MNlPm7c'
        ,'0'=>'AIzaSyDoDXwO8R5wVWLPrUux3XsZ4X1wQ7tePlU','cps'=>'AIzaSyDoDXwO8R5wVWLPrUux3XsZ4X1wQ7tePlU');
        $GOOGLE_API_KEY = $data[$tenant];
        return $this->pushGCMBase($GOOGLE_API_KEY,$registatoin_ids, $message);

    }

    function pushGCMBase($GOOGLE_API_KEY,$registatoin_ids, $messageData) {
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        if(!is_array($registatoin_ids)){
            $registatoin_ids = explode(",", $registatoin_ids);
        }

        $message = array();
        $message['title'] = $messageData['title'];//'notification';
        $message['message'] = $messageData['message'];//'notification';
        $message['action'] = $messageData['action'];//'notification';
        $message['extraData'] = $messageData;

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,

        );

        $headers = array(
            'Authorization: key=' . $GOOGLE_API_KEY,
            'Content-Type: application/json'
        );


        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post
        $result = curl_exec($ch);

        if ( curl_errno($ch) ){
            $result = 'GCM error: ' . curl_error( $ch );
        }
        if ($result === FALSE) {
            //die('Curl failed: ' . curl_error($ch));
            return array('s'=>'500', 'm'=>curl_error($ch));
        }


        // Close connection
        curl_close($ch);
        return array('s'=>'200',  'msg' => $message ,  'data'=>$result );



    }

}