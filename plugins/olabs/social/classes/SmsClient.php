<?
namespace Olabs\Social\Classes;

use Model;

use BackendAuth;
use Backend;
use Config;
use Event;
use Cache;
use Request;


use Flash;
class SmsClient{

    /**

     returns ['MessageId'=>'xyz'] on success
    **/
	public function publish($number,$message){

		//$message = 'hello test';
		//$number ='+91-9958202825';

		//Yii::log("************* SmsClient::publish ", CLogger::LEVEL_INFO);
		$status = array('s'=>'100');
        

		$sns = \Aws\Sns\SnsClient::factory(array(
        'credentials' => array(
            'key' => '',
            'secret' => '/ZDfJZ'
        ),
        'region' => 'ap-southeast-1',
        'version' => 'latest'
       ));


         $msgattributes = [
        'AWS.SNS.SMS.SenderID' => [
            'DataType' => 'String',
            'StringValue' => 'mySenderID',
        ],
        'AWS.SNS.SMS.SMSType' => [
            'DataType' => 'String',
            'StringValue' => 'Transactional',
        ]
    ];

    $payload = array(
        'Message' => $message,
        'PhoneNumber' => $number,
        'MessageAttributes' => $msgattributes
    );

    $result=$sns->publish($payload);
      return $result;
	}


	}?>