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
        'tax' => [
            'Olabs\Oims\Models\Tax', 
            'key' => 'tax_id'
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
//        if ($this->product) {
////            dd($this->product->unit);
//            $fields->unit_code->value = $this->product->unit;
//            $fields->unit_price->value = $fields->unit_price->value > 0 ?$fields->unit_price->value : $this->product->retail_price_with_tax;
//            $fields->total_price->value = $fields->unit_price->value * $fields->quantity->value;
//        }
        if ($this->product) {
//            $fields->unit_price->value = $fields->unit_price->value > 0 ?$fields->unit_price->value : $this->product->retail_price_with_tax;
            
            $fields->pre_tax_retail_price->value = $fields->pre_tax_retail_price->value > 0 ?$fields->pre_tax_retail_price->value : $this->product->pre_tax_retail_price;
//            $fields->retail_price_with_tax->value = $fields->retail_price_with_tax->value > 0 ?$fields->retail_price_with_tax->value : $this->product->retail_price_with_tax;
//            $fields->tax->value = $fields->tax->value > 0 ? $fields->tax->value : $this->product->tax;
            $fields->unit_price->value = $fields->unit_price->value > 0 ?$fields->unit_price->value : $this->product->retail_price_with_tax;
            
            if($this->product->tax_id > 0){
                $fields->tax->value = $this->product->tax_id ;
                $fields->tax_percent->value = $this->product->percent;
                $fields->tax->disabled = true;
//                $fields->tax_percent->disabled = true;
            }else{
                
                $fields->tax->disabled = false;
//                $fields->tax_percent->disabled = false;
            }
            
            $fields->tax_code->value = $this->product->tax_code;
            
            
        }
        //calculate Unit Price based on tax
        if($fields->tax->value){
            $tax_modal = Tax::where('id',$fields->tax->value)->first();
            $tax_percentage = 0;
            if($tax_modal){
                $tax_percentage = $tax_modal->percent;
            }
//            dd($tax_percentage);
            
            $retail_price_with_out_tax = $fields->pre_tax_retail_price->value > 0? $fields->pre_tax_retail_price->value : 0;
            $unit_price = $retail_price_with_out_tax + ($retail_price_with_out_tax / 100 * $tax_percentage);
            $fields->unit_price->value = $unit_price;
            $fields->tax_percent->value = $tax_percentage;
        }
        $unit_tax = $fields->unit_price->value - $fields->pre_tax_retail_price->value;
        $fields->total_price->value = $fields->unit_price->value * $fields->quantity->value;
        $fields->total_tax->value = $unit_tax * $fields->quantity->value;
        
    }

    public static function getPurchaseProducts($purchaseId){
        $products = PurchaseProduct::where('purchase_id', $purchaseId)->get();
        return $products;
    }
}