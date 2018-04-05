<?php namespace Olabs\Iot\Models;

use Model;

/**
 * Model
 */
class AwsMessage extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    const REQUEST_TYPE_GSM = 'gsm';
    const REQUEST_TYPE_GPRS = 'gprs';
    


    /*
     * Validation
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_iot_aws_message';
}