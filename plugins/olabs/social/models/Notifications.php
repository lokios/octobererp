<?php namespace Olabs\Social\Models;

use Model;
use Olabs\Social\Classes\SmsClient;

/**
 * Model
 */
class Notifications extends Model
{
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
        'client' => ['Olabs\Social\Models\Clients','key'=>'tenant_id'],
        
    ];


     /**
     * Allows filtering for specifc categories
     * @param  Illuminate\Query\Builder  $query      QueryBuilder
     * @param  array                     $categories List of category ids
     * @return Illuminate\Query\Builder              QueryBuilder
     */
    public function scopeFilterCategories($query, $categories)
    {
        return $query->whereHas('client', function($q) use ($categories) {
            $q->whereIn('id', $categories);
        });
    }

    public function afterSave(){

        if(!$this->data){
            return  ;//parent::afterSave();
        }

         if(!$this->status){
           $this->status = '100';
         }

        if($this->status !='100'){
            return;
        }


        foreach ($this->data as $key => $value) {
            # code...
            if(isset($value['type']) && $value['type'] == 'sms'){
                 //$value['to'] = '9958202825';
                 //$value['message'] = '9958202825';

                 $this->sendSmsViaAws($value['to'],$value['message']);
                
           }
        }
        $this->updated_at = date('Y-m-d H:i:s');
        $this->status ='200';
        $this->save();


    }


    public  function sendSmsViaAws($smsTo , $msgText){
        $sendSms = false;
       // Yii::log("sendSmsViaAws content ::".CVarDumper::dumpAsString($smsTo." ".$msgText), CLogger::LEVEL_INFO);
        if(is_array($smsTo)){
            $smsTo = array_unique($smsTo);
            foreach ($smsTo as $key => $num) {
                $sendSms = $this->i_sendSmsViaAws($num, $msgText);
            }
        }elseif (strpos($smsTo, ',') !== false){
            // comma separated mobile numbers
            $smsArray = explode(',', $smsTo);
            $smsArray = array_unique($smsArray);
            foreach ($smsArray as $key => $num) {
                $sendSms =  $this->i_sendSmsViaAws($num, $msgText);
            }
        }else{
            // single mobile number
            $sendSms =  $this->i_sendSmsViaAws($smsTo, $msgText);
        }
        

        return $sendSms;
        
    }
    
    public function  i_sendSmsViaAws($smsTo , $msgText){
        
        $sendSms = false;
        $smsTo = trim($smsTo);
        $num_length = strlen((string)$smsTo);
        if($num_length > 0){
            
            if($num_length == 10) {
                // if mobile number without country code then add 91 as default country code
                $smsTo = '91'.$smsTo;
            }

            $smsclient = new SmsClient();
            $response = $smsclient->publish($smsTo , $msgText);
           // Yii::log("_sendSmsViaAws content ::".CVarDumper::dumpAsString($smsTo." ".$msgText), CLogger::LEVEL_INFO);
            if(!empty($response['MessageId'])){
                $sendSms = true;
                $this->sms_count++;


            }else{
                //Yii::log("sendSmsViaAws response ::".CVarDumper::dumpAsString($response), CLogger::LEVEL_INFO);
            }
            
        }
        
        return $sendSms;
        
    }
}