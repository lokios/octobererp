<?php

namespace Olabs\Messaging\Classes;

use Model;
use BackendAuth;
use Backend;
use Config;
use Event;
use Cache;
use Request;
use Flash;

class FcmClient {

    /**

      returns ['MessageId'=>'xyz'] on success
     * */
    public function publish($api_key, $token , $message) {
        
//        $msgData = [
//            'message' => $message,
//            'title' => $title
//        ];
        
        $fields = 
         [
            'registration_ids'  => [$token],
            'data'      => $message
         ];
         
         $headers = 
         [
           'Authorization: key=' . $api_key,
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
        
//        //$message = 'hello test';
//        //$number ='+91-9958202825';
//        //Yii::log("************* SmsClient::publish ", CLogger::LEVEL_INFO);
//        $status = array('s' => '100');
//        //require 'aws-autoloader.php';
//        //require_once('/home/ezpt/ezhealthtrack/protected' .'/extensions/aws.phar');
//
//
//        $sns = \Aws\Sns\SnsClient::factory(array(
//                    'credentials' => array(
//                        'key' => 'AKIAIIQMM5CBVSK3BK4A',
//                        'secret' => '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'
//                    ),
//                    'region' => 'ap-southeast-1',
//                    'version' => 'latest'
//        ));
//
//
//        $msgattributes = [
//            'AWS.SNS.SMS.SenderID' => [
//                'DataType' => 'String',
//                'StringValue' => 'mySenderID',
//            ],
//            'AWS.SNS.SMS.SMSType' => [
//                'DataType' => 'String',
//                'StringValue' => 'Transactional',
//            ]
//        ];
//
//        $payload = array(
//            'Message' => $message,
//            'PhoneNumber' => $number,
//            'MessageAttributes' => $msgattributes
//        );
//
//        $result = $sns->publish($payload);
//        return $result;
    }

}

