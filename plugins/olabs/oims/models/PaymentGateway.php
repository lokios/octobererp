<?php namespace Olabs\Oims\Models;

use Model;
use \Omnipay\Omnipay;
use Cms\Classes\Page;

/**
 * PaymentGateway Model
 */
class PaymentGateway extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_payment_gateways';
    
    use \October\Rain\Database\Traits\Validation;
    public $rules = [
        'gateway_title' => 'required',
        'gateway_currency' => 'required',
        'payment_page' => 'required',
    ];    
    public $customMessages = [];
    
    
    /**
     * TranslatableModel
     *
     * @var type 
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = [
        'gateway_title', 
    ];
    
    
    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        "active",
        "gateway",
        "gateway_title",
        "gateway_currency",
        "payment_page",
    ];
    
    protected $jsonable = ['parameters'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
    
    
    public $belongsTo = [
        'orderStatusBefore' => [
            'Olabs\Oims\Models\OrderStatus', 
            'key' => 'order_status_before_id'
        ],
        'orderStatusAfter' => [
            'Olabs\Oims\Models\OrderStatus', 
            'key' => 'order_status_after_id'
        ]
    ];
    
    /**
     * Get Payment Page Options
     * 
     * @return type
     */
    public function getPaymentPageOptions() {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }    
    
    /**
     * Get ALL Omnipay Gateways
     * 
     * @return type
     */
    public function getGatewayOptions() {
        $data = self::getGatewayOptionsStatic();
        return [null => "--- Please select ---"] + $data;
    }
    
    /**
     * Get all payment gateways static
     * 
     * @return type
     */
    public static function getGatewayOptionsStatic() {
        
        /* this show only basic clases from JSON */
        $factory = Omnipay::getFactory();
        
        $allGateways = $factory->find();
        
        $data = [];
        
        foreach ($allGateways as $gateway) {
           $data[$gateway] = $gateway;
        }
        
        return $data;
    }
    
    /**
     * Get Implementing Classes
     * 
     * @param type $interfaceName
     * @return type
     */
    public static function getImplementingClasses( $interfaceName ) {
        return array_filter(
            get_declared_classes(),
            function( $className ) use ( $interfaceName ) {
                return in_array( $interfaceName, class_implements( $className ) );
            }
        );
    }
    
    /**
     * Get parameters fields for current payment
     * 
     * @return type
     */
    public function getParametersFields() {
        
        return self::getParametersFieldsStatic($this->gateway);
    }
    
    /**
     * Get parameters fields for current payment
     * 
     * @param type $gateway
     * @return type
     */
    public static function getParametersFieldsStatic($gateway) {
        if (empty($gateway)) {
            return [];
        }
        else {
            $gateway = Omnipay::create($gateway);
            return $gateway->getDefaultParameters();
        }        
    }
    

}