<?php namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class MachineryProduct extends Model
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
        'machinery' => [
            'Olabs\Oims\Models\Machinery',
            'key' => 'machinery_id'
        ],
        'product' => [
            'Olabs\Oims\Models\Product', 
            'key' => 'product_id',
            'conditions' => 'default_category_id = (SELECT id FROM olabs_oims_categories where slug = "machinery-expenditure")',
        ],   
        'unit_code' => [
            'Olabs\Oims\Models\Unit', 
            'key' => 'unit'
        ],
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_machinery_products';
    
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

    public static function getPurchaseProducts($machineryId){
        $products = MachineryProduct::where('machinery_id', $machineryId)->get();
        return $products;
    }
}