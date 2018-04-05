<?php namespace Olabs\Oims\Models;

use Model;
/**
 * Model
 */
class PurchaseProduct extends Model
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
        'purchase' => [
            'Olabs\Oims\Models\Purchase',
            'key' => 'purchase_id'
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
    public $table = 'olabs_oims_purchase_products';
    
    /**
     * @var array Guarded fields
     */
    protected $guarded = [];
    
    public function filterFields($fields, $context = null)
    {
//        $fields->unit_code->value = "unit";
        if ($this->product) {
//            dd($this->product->unit);
            $fields->unit_code->value = $this->product->unit;
            $fields->unit_price->value = $fields->unit_price->value > 0 ?$fields->unit_price->value : $this->product->retail_price_with_tax;
            $fields->total_price->value = $fields->unit_price->value * $fields->quantity->value;
        }
    }

    public static function getPurchaseProducts($purchaseId){
        $products = PurchaseProduct::where('purchase_id', $purchaseId)->get();
        return $products;
    }
}