<?php namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class ProjectWorkProduct extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    public $project_work_quantity;
    
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
        'projectWork' => [
            'Olabs\Oims\Models\ProjectWork',
            'key' => 'project_work_id'
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
    public $table = 'olabs_oims_project_work_products';
    
    /**
     * @var array Guarded fields
     */
    protected $guarded = [];
    
    public function filterFields($fields, $context = null)
    {
        $project_work_quantity = \Session::get('projectWork_quantity', $this->project_work_quantity);
//        echo "C : $this->coefficient, Q : $this->quantity ";
//        dd($this->coefficient);
        if ($this->product) {
            $fields->unit_price->value = $fields->unit_price->value > 0 ?$fields->unit_price->value : $this->product->retail_price_with_tax;
            $field_coefficient = $fields->coefficient->value > 0 ? $fields->coefficient->value : 0;
            $field_quantity = $fields->quantity->value > 0 ? $fields->quantity->value : 0;
            
//            $calculated_coefficient = $field_quantity / $project_work_quantity;
            
            $calculated_quantity = $project_work_quantity * $field_coefficient;
            
//            $fields->coefficient->value = $calculated_coefficient;
            $fields->quantity->value = $calculated_quantity;
            
            $fields->total_price->value = $fields->unit_price->value * $calculated_quantity;
        }
        if($this->coefficient){
            
        }
    }
}