<?php namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class SalesProduct extends Model
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
        'sales' => [
            'Olabs\Oims\Models\Sales',
            'key' => 'sales_id'
        ],
        'product' => [
            'Olabs\Oims\Models\Product', 
            'key' => 'product_id'
        ], 
        'unit_code' => [
            'Olabs\Oims\Models\Unit', 
            'key' => 'unit'
        ],
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_sales_products';
    
    /**
     * @var array Guarded fields
     */
    protected $guarded = [];
    
    public function filterFields($fields, $context = null)
    {
        if ($this->product) {
            $unitPriceValue = isset($fields->unit_price->value) ? $fields->unit_price->value : 0;
            $retailPrice = isset($this->product->retail_price_with_tax) ? $this->product->retail_price_with_tax : 0;
            $unitPriceValue = $unitPriceValue > 0 ? $unitPriceValue : $retailPrice;
            if(isset($fields->total_price->value)){
                $quantity = isset($fields->quantity->value) ? $fields->quantity->value : 0;
                $fields->total_price->value = $unitPriceValue * $quantity;
            }
        }
    }
}