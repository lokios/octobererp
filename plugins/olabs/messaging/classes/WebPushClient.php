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

class WebPushClient {

    /**

      returns ['MessageId'=>'xyz'] on success
     * */
    public function publish($to, $message) {

        //$message = 'hello test';
        //$number ='+91-9958202825';
        //Yii::log("************* SmsClient::publish ", CLogger::LEVEL_INFO);
        $status = array('s' => '100');
        //require 'aws-autoloader.php';
        //require_once('/home/ezpt/ezhealthtrack/protected' .'/extensions/aws.phar');

        $result = array('s' => '200', 'message' => 'to be implemented');
        
        return $result;
    }

}

