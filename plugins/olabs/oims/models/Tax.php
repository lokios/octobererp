<?php namespace Olabs\Oims\Models;

use Model;

/**
 * Tax Model
 */
class Tax extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_taxes';

    
    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'name' => 'required|between:3,255',
        'percent' => 'numeric|min:0',
    ];    
    
    
    /**
     * TranslatableModel
     *
     * @var type 
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = [
        'name', 
    ];
    
    
    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'active',
        'percent',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
    
    /**
     * Get tax only from price with tax
     * 
     * @param type $price
     * @return type
     */
    public function getTaxFromPriceWithTax($price) {
        $priceWithoutTax = ($price/(100+$this->percent)) * 100;
        return round($price - $priceWithoutTax,2);
    }
    
    /**
     * Get price with tax for price whitout tax
     * 
     * @param type $priceWhitoutTax
     * @return type
     */
    public function getPriceWithTax($priceWhitoutTax) {
        return round($priceWhitoutTax / 100 * (100 + $this->percent),2);
    }

}