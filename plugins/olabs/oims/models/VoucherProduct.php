<?php namespace Olabs\Oims\Models;

use Model;
/**
 * Model
 */
class VoucherProduct extends BaseModel
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
        'voucher' => [
            'Olabs\Oims\Models\Voucher',
            'key' => 'voucher_id'
        ],
        'product' => [
            'Olabs\Oims\Models\Product', 
            'key' => 'product_id'
        ],   
        'unit_code' => [
            'Olabs\Oims\Models\Unit', 
            'key' => 'unit'
        ],
        'purchase' => [
            'Olabs\Oims\Models\Purchase', 
            'key' => 'purchase_id'
        ],   
        'supplier' => [
//            'Backend\Models\User', 
            'Olabs\Oims\Models\Supplier', 
            'key' => 'supplier_id'
        ],     
        'employee' => [
//            'Backend\Models\User', 
            'Olabs\Oims\Models\Employee', 
            'key' => 'employee_id'
        ],   
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_voucher_products';
    
    /**
     * @var array Guarded fields
     */
    protected $guarded = [];
    
    public function filterFields($fields, $context = null)
    {
//        $fields->unit_code->value = "unit";
        if ($this->purchase) {
//            dd($this->product->unit);
//            $fields->unit_code->value = $this->product->unit;
//            $fields->unit_price->value = $fields->unit_price->value > 0 ?$fields->unit_price->value : $this->product->retail_price_with_tax;
            $fields->total_price->value = $this->purchase->total_price;
        }
    }

    public static function getVoucherProducts($voucherId){
        $products = VoucherProduct::where('voucher_id', $voucherId)->get();
        return $products;
    }
}