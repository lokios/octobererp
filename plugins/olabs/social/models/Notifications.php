<?php

namespace Olabs\Social\Models;

use Model;
use Olabs\Social\Classes\SmsClient;
use Olabs\Social\Classes\FcmClient;
use Olabs\Social\Classes\EmailClient;
use Olabs\Social\Classes\WebPushClient;

/**
 * Model
 */
class Notifications extends Model {

    use \October\Rain\Database\Traits\Validation;

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */

    public $timestamps = true;

    /*
     * Validation
     */
    public $rules = [
    ];
    protected $jsonable = ['data'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_social_notifications';
    public $belongsTo = [
        'client' => ['Olabs\Social\Models\Clients', 'key' => 'tenant_id'],
    ];

    /**
     * Allows filtering for specifc categories
     * @param  Illuminate\Query\Builder  $query      QueryBuilder
     * @param  array                     $categories List of category ids
     * @return Illuminate\Query\Builder              QueryBuilder
     */
    public function scopeFilterCategories($query, $categories) {
        return $query->whereHas('client', function($q) use ($categories) {
                    $q->whereIn('id', $categories);
                });
    }

    public function afterSave() {

        if (!$this->data) {
            return; //parent::afterSave();
        }

        if (!$this->status) {
            $this->status = '100';
        }

        if ($this->status != '100') {
            return;
        }

//        dd($this->data);
        foreach ($this->data as $key => $value) {
            # code...
            if (isset($value['type']) && $value['type'] == 'sms') {
                //$value['to'] = '9958202825';
                //$value['message'] = '9958202825';

                $this->sendSmsViaAws($value['to'], $value['message']);
            } else if (isset($value['type']) && $value['type'] == 'fcm') {
                //$value['to'] = '9958202825';
                //$value['message'] = '9958202825';

                $this->sendFCM($value['fcm_token'], $value['title'], $value['message']);
            } else if (isset($value['type']) && $value['type'] == 'email') {
                //$value['to'] = '9958202825';
                //$value['message'] = '9958202825';

                $this->sendEmail($value['to'], $value['title'], $value['message']);
            }else if (isset($value['type']) && $value['type'] == 'web_push') {
                //$value['to'] = '9958202825';
                //$value['message'] = '9958202825';

                $this->sendWebPush($value['to'], $value['title'], $value['message']);
            }
        }
        $this->updated_at = date('Y-m-d H:i:s');
        $this->status = '200';
        $this->save();
    }

    //FCM
    public function sendFCM($token, $title, $message) {
        $status = FALSE;
        $api_key = isset($this->client) ? $this->client->fcm_access_key : '';
        $msgData = [
            'message' => $message,
            'title' => $title
        ];
//        dd($api_key);
        if ($api_key != '' && $token != '') {

            $fcm_client = new FcmClient();
            $response = $fcm_client->publish($api_key, $token, $msgData);
            // Yii::log("_sendSmsViaAws content ::".CVarDumper::dumpAsString($smsTo." ".$msgText), CLogger::LEVEL_INFO);
            if (isset($response['s']) && $response['s'] == '200') {
                $status = true;
                $this->mobile_push_count++;
                $this->mobile_push_status = $response['s'];
                $this->mobile_push_sent_at = date('Y-m-d H:i:s');
//                $this->mobile_push_status = 200;
            } else {
                //Yii::log("sendSmsViaAws response ::".CVarDumper::dumpAsString($response), CLogger::LEVEL_INFO);
            }
        }

        return $status;
    }

    
    //Email @todo
    public function sendEmail($to, $subject, $message) {
        $status = FALSE;
//        $api_key = isset($this->client) ? $this->client->fcm_access_key : '';
        $msgData = [
            'message' => $message,
            'subject' => $subject
        ];
//        dd($api_key);
//        if ($api_key != '' && $token != '') {

            $email_client = new EmailClient();
            $response = $email_client->publish($to, $msgData);
            // Yii::log("_sendSmsViaAws content ::".CVarDumper::dumpAsString($smsTo." ".$msgText), CLogger::LEVEL_INFO);
            if (isset($response['s']) && $response['s'] == '200') {
                $status = true;
                $this->email_count++;
                $this->email_status = $response['s'];
                $this->email_sent_at = date('Y-m-d H:i:s');
//                $this->mobile_push_status = 200;
            } else {
                //Yii::log("sendSmsViaAws response ::".CVarDumper::dumpAsString($response), CLogger::LEVEL_INFO);
            }
//        }

        return $status;
    }
        
    //Email @todo
    public function sendWebPush($to, $subject, $message) {
        $status = FALSE;
//        $api_key = isset($this->client) ? $this->client->fcm_access_key : '';
        $msgData = [
            'message' => $message,
            'subject' => $subject
        ];
//        dd($api_key);
//        if ($api_key != '' && $token != '') {

            $web_push_client = new WebPushClient();
            $response = $web_push_client->publish($to, $msgData);
            // Yii::log("_sendSmsViaAws content ::".CVarDumper::dumpAsString($smsTo." ".$msgText), CLogger::LEVEL_INFO);
            if (isset($response['s']) && $response['s'] == '200') {
                $status = true;
                $this->web_push_count++;
                $this->web_push_status = $response['s'];
                $this->web_push_sent_at = date('Y-m-d H:i:s');
//                $this->mobile_push_status = 200;
            } else {
                //Yii::log("sendSmsViaAws response ::".CVarDumper::dumpAsString($response), CLogger::LEVEL_INFO);
            }
//        }

        return $status;
    }
            
    
    
    
    //SMS


    public function sendSmsViaAws($smsTo, $msgText) {
        $sendSms = false;
        // Yii::log("sendSmsViaAws content ::".CVarDumper::dumpAsString($smsTo." ".$msgText), CLogger::LEVEL_INFO);
        if (is_array($smsTo)) {
            $smsTo = array_unique($smsTo);
            foreach ($smsTo as $key => $num) {
                $sendSms = $this->i_sendSmsViaAws($num, $msgText);
            }
        } elseif (strpos($smsTo, ',') !== false) {
            // comma separated mobile numbers
            $smsArray = explode(',', $smsTo);
            $smsArray = array_unique($smsArray);
            foreach ($smsArray as $key => $num) {
                $sendSms = $this->i_sendSmsViaAws($num, $msgText);
            }
        } else {
            // single mobile number
            $sendSms = $this->i_sendSmsViaAws($smsTo, $msgText);
        }


        return $sendSms;
    }

    public function i_sendSmsViaAws($smsTo, $msgText) {

        $sendSms = false;
        $smsTo = trim($smsTo);
        $num_length = strlen((string) $smsTo);
        if ($num_length > 0) {

            if ($num_length == 10) {
                // if mobile number without country code then add 91 as default country code
                $smsTo = '91' . $smsTo;
            }

            $smsclient = new SmsClient();
            $response = $smsclient->publish($smsTo, $msgText);
            // Yii::log("_sendSmsViaAws content ::".CVarDumper::dumpAsString($smsTo." ".$msgText), CLogger::LEVEL_INFO);
            if (!empty($response['MessageId'])) {
                $sendSms = true;
//                $this->sms_count++;
                $this->sms_count++;
                $this->sms_status = '200';
                $this->sms_sent_at = date('Y-m-d H:i:s');
//                $this->mobile_push_status = 200;
            } else {
                //Yii::log("sendSmsViaAws response ::".CVarDumper::dumpAsString($response), CLogger::LEVEL_INFO);
            }
        }

        return $sendSms;
    }

}
