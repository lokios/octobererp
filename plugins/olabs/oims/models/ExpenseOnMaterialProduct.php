<?php namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class ExpenseOnMaterialProduct extends Model
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
        'expense_on_material' => [
            'Olabs\Oims\Models\ExpenseOnMaterial',
            'key' => 'expense_on_material_id'
        ],
        'product' => [
            'Olabs\Oims\Models\Product', 
            'key' => 'product_id',
/*            'conditions' => 'default_category_id = (SELECT id FROM olabs_oims_categories where slug = "machinery-expenditure")', */
        ],   
        'unit_code' => [
            'Olabs\Oims\Models\Unit', 
            'key' => 'unit'
        ],
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_expense_on_material_products';
    
    /**
     * @var array Guarded fields
     */
    protected $guarded = [];
    
    public function filterFields($fields, $context = null)
    {

        if ($this->product) {
            $fields->unit_price->value = $fields->unit_price->value > 0 ?$fields->unit_price->value : $this->product->retail_price_with_tax;
            $fields->total_price->value = $fields->unit_price->value * $fields->quantity->value ;
        }
    }

    public static function getPurchaseProducts($expenseOnMaterialId){
        $products = ExpenseOnMaterialProduct::where('expense_on_material_id', $expenseOnMaterialId)->get();
        return $products;
    }
}