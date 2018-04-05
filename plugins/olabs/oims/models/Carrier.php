<?php namespace Olabs\Oims\Models;

use Model;
use Lang;

/**
 * Carrier Model
 */
class Carrier extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_carriers';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];
    
    
    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'title' => 'required|between:3,255',
        'transit_time' => 'required|between:1,255',

        'speed_grade'  => 'numeric|min:0',
        
        'maximum_package_width'  => 'numeric|min:0',
        'maximum_package_height'  => 'numeric|min:0',
        'maximum_package_depth'  => 'numeric|min:0',
        'maximum_package_weight'  => 'numeric|min:0'
    ]; 
    
    /**
     * TranslatableModel
     *
     * @var type 
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = [
        'title', 
        'transit_time',
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'title',
        'active',

        'transit_time',
        'speed_grade',
        'tracking_url',

        'free_shipping',
        'tax',

        'billing', // 1-total price, 2-weight

        'billing_total_price',
        'billing_weight',

        'maximum_package_width',
        'maximum_package_height',
        'maximum_package_depth',
        'maximum_package_weight',        
    ];
    
    protected $jsonable = ['billing_total_price', 'billing_weight'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'tax' => [
            'Olabs\Oims\Models\Tax', 
            'key' => 'tax_id'
        ],        
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'logo' => 'System\Models\File'
    ];

    public $attachMany = [];
    
    
    public function getBillingOptions($keyValue = null)
    {
        return [
            1 => Lang::get("olabs.oims::lang.carriers.billing_1"),
            2 => Lang::get("olabs.oims::lang.carriers.billing_2"),
        ];
    }
    
    /**
     * Check when this carrier can transport this basket
     * 
     * @param type $basket
     * @return boolean
     */
    public function isAvaliableForThisOrder($basket) {
        // check corretc price rule for this order
        if ($this->getCurrentPrice($basket) === null) {
            return false;
        }
        
        // check  maximum_package_weight
        if (($this->maximum_package_weight != 0) && ($basket["total_weight"] > $this->maximum_package_weight)) {
            return false;
        }
        
        // check maximum_package_height
        if ($this->maximum_package_height != 0) {
            if ($this->maximum_package_height < $basket["max_product_height"]) {
                return false;
            }
        }
        
        // check maximum_package_depth
        if ($this->maximum_package_depth != 0) {
            if ($this->maximum_package_depth < $basket["max_product_depth"]) {
                return false;
            }
        }
        
        // maximum_package_width
        if ($this->maximum_package_width != 0) {
            if ($this->maximum_package_width < $basket["max_product_width"]) {
                return false;
            }
        }
        
        // all ok
        return true;
    
    }
    
    /**
     * Compute current price by rules for basket without tax
     * 
     * @param type $basket
     * @return int
     */
    public function getCurrentPrice($basket) {
        // free
        if ($this->free_shipping == 1) {
            return 0;
        }

        switch ($this->billing) {
            case 1:
                // According to total price.
                foreach ($this->billing_total_price as $bw) {
                    
                    if (($bw["from"] <= $basket["total_price"]) && ($bw["to"] > $basket["total_price"])) {
                        return $bw["price"]+$basket["additional_shipping_fees"];
                    }
                }
                break;
            case 2:
                // According to total weight.
                foreach ($this->billing_weight as $bw) {
                    
                    if (($bw["from"] <= $basket["total_weight"]) && ($bw["to"] > $basket["total_weight"])) {
                        return $bw["price"]+$basket["additional_shipping_fees"];
                    }
                }
                break;
        }
        

        // error, something is wrong, it isn't possible use this carrier for this basket
        return null;        
    }
    
    
    /**
     * Compute current price by rules for basket with tax
     * 
     * @param type $basket
     * @return int
     */
    public function getCurrentPriceWithTax($basket) {
        $price = $this->getCurrentPrice($basket);
        return $this->getPriceWithTax($price);
    }
    

    /**
     * Get price with tax
     * 
     * @param type $price
     * @return type
     */
    public function getPriceWithTax($price) {
        if ($this->tax != null) {
            return $this->tax->getPriceWithTax($price);
        }
        
        return $price;
    }

}