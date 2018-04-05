<?php namespace Olabs\Oims\Models;

use Model;
use Lang;

/**
 * Coupon Model
 */
class Coupon extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_coupons';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        "code",
        "active",
        "count",
        "used_count",
        "minimum_value_basket",
        "type_value", // 1-percent, 2-money
        "value",
    ];
    
    protected $dates = [
        'valid_from',
        'valid_to'
        ];
    
    /**
     * Validation
     */    
    use \October\Rain\Database\Traits\Validation;
    public $rules = [
        'value' => 'required',
        'code'=> 'unique:olabs_oims_coupons'
    ];    

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'categories' => [
            'Olabs\Oims\Models\Category',
            'table'    => 'olabs_oims_coupons_categories',
            'key'      => 'coupon_id',
            'otherKey' => 'category_id'
        ],
        'products' => [
            'Olabs\Oims\Models\Product',
            'table'    => 'olabs_oims_coupons_products',
            'key'      => 'coupon_id',
            'otherKey' => 'product_id'
        ],
        'users' => [
            'RainLab\User\Models\User',
            'table'    => 'olabs_oims_coupons_users',
            'key'      => 'coupon_id',
            'otherKey' => 'user_id'
        ],        
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    
    /**
     * Get type of values
     * 
     * @return type
     */
    public function getTypeValueOptions()
    {
        return [
            1 => Lang::get("jiri.jkshop::lang.coupons.type_value_1"),
            2 => Lang::get("jiri.jkshop::lang.coupons.type_value_2"),
        ];
    }
    
    /**
     * Before create
     */
    public function beforeCreate() {
        $this->code = str_random(8);
    }
    
    /**
     * Check if this coupon it can be use for one current product 
     * - global coupons return false
     * 
     * @param type $product
     * @return boolean
     */
    public function isValidForCurrentProduct($product) {
        
        // global coupon - false
        if ((count($this->categories) == 0) && (count($this->products) == 0)) {
            return false;
        }
        
        
        // check categories
        if (count($this->categories) > 0) {
            
            // check default category
            if ($this->categories()->where("id", $product->default_category->id)->count() > 0) {
                return true;
            }

            // check cateogires
            foreach ($product->categories as $category) {
                if ($this->categories()->where("id", $category->id)->count() > 0) {
                    return true;
                }
            }
            
        }
            
        // check products
        if (count($this->products) > 0) {
                
            // check default category
            if ($this->products()->where("id", $product->id)->count() > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * It can be use for a complete basket (one / basket)
     * 
     * @param type $totalBasketPrice
     * @param type $outWrongCode
     * 0..4 - is in isValid
     * 5 - low minimal value basket
     * @return boolean
     */
    public function isValidGlobal($totalBasketPrice, &$outWrongCode) {

        // global coupon
        if ((count($this->categories) == 0) && (count($this->products) == 0)) {
            
            if ($this->minimum_value_basket > 0) {
                if ($this->minimum_value_basket <= $totalBasketPrice) {
                    return true;
                }
            }
            else {
                return true;
            }
        }
        
        return false;
    }
    
    
    /**
     * Compute real price coupons
     * 
     * @param type $fromPrice - only for percentage sale
     */
    public function getFinalDiscount($fromPrice) {
        
        if ($this->type_value==1) {
            return (($fromPrice/100)*$this->value);
        }
        else {
            return $this->value;
        }
    }
    
    /**
     * Check if is coupon valid - main validation
     * 
     * @param type $wrongCode
     * 0 - OK
     * 1 - active false
     * 2 - invalid date
     * 3 - count >= used_count
     * 4 - bad user
     * 5 - is in isValidGlobal - low minimal value basket
     * @return boolean
     */
    public function isValid(&$outWrongCode) {
        
        $outWrongCode = 0;
        
        // check active
        if ($this->active == false) {
            $outWrongCode = 1;
            return false;
        }
        
        // check date to
        if ($this->valid_to != null) {
            if (\Carbon\Carbon::parse($this->valid_to)->isPast()) {
                $outWrongCode = 2;
                return false;
            }
        }
        if ($this->valid_from != null) {
            if (\Carbon\Carbon::parse($this->valid_from)->isFuture()) {
                $outWrongCode = 2;
                return false;
            }
        }
        
        
        // check count
        if ($this->count > 0) {
            if ($this->used_count >= $this->count) {
                $outWrongCode = 3;
                return false;
            }
        }
        
        /*
        // check minimum_value_basket
        if ($this->minimum_value_basket > 0) {
            if ($basket["total_price"] < $this->minimum_value_basket) {
                return false;
            }
        }
        */
        
        // check users
        if (count($this->users) > 0) {
            $wValidUser = false;
            
            $user = null;
            if (class_exists("\RainLab\User\Models\User")) {
                $user = \RainLab\User\Facades\Auth::getUser();
            }
                
            if ($user != null) {
                foreach ($this->users as $iUser) {
                    if ($iUser->id == $user->id) {
                        $wValidUser = true;
                        break;
                    }
                }
            }
            
            // only if false - return false
            if ($wValidUser == false) {
                return false;
                $outWrongCode = 4;
            }
        }
        
        return true;
    }
    
    /**
     * Get value coupon with label - formated string
     * 
     * @return type
     */
    public function getValueLabel() {
        $jkshopSetting = \Olabs\Oims\Models\Settings::instance();
        
        if ($this->type_value==1) {
            return $this->value."%";
        }
        else {
            return $jkshopSetting->getPriceFormatted($this->value);
        }        
    }
    
    /**
     * Helper - is global coupon
     * 
     * @return boolean
     */
    public function isGlobal() {

        // global coupon
        if ((count($this->categories) == 0) && (count($this->products) == 0)) {
            return true;
        }
        
        return false;
    }    
}