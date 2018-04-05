<?php namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class ManpowerProduct extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /*
     * Validation
     */
    public $rules = [
    ];
    
    public $belongsTo = [
        'manpower' => [
            'Olabs\Oims\Models\Manpower',
            'key' => 'manpower_id'
        ],
        'product' => [
            'Olabs\Oims\Models\Product', 
            'key' => 'product_id',
//            'scope' => 'isManpowerProduct',
            'conditions' => 'default_category_id = (SELECT id FROM olabs_oims_categories where slug = "consumed-manpower")',
        ],   
        'unit_code' => [
            'Olabs\Oims\Models\Unit', 
            'key' => 'unit'
        ],
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_manpower_products';
    
//    public function scopeIsManpowerProduct($query){
//         return $query->where('field_type','=','email');
//    }

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];
    
    public function filterFields($fields, $context = null)
    {

        if ($this->product) {
            $fields->unit_value->value = $fields->unit_value->value > 0 ?$fields->unit_value->value : 1;
            $fields->unit_price->value = $fields->unit_price->value > 0 ?$fields->unit_price->value : $this->product->retail_price_with_tax;
            $fields->total_price->value = $fields->unit_price->value * $fields->quantity->value * $fields->unit_value->value;
        }
    }

    public static function getPurchaseProducts($manpowerId){
        $products = ManpowerProduct::where('manpower_id', $manpowerId)->get();
        return $products;
    }
}