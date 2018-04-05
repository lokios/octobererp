<?php namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class ProjectProgressItem extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $project_id;
    
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
        'project_progress' => [
            'Olabs\Oims\Models\ProjectProgress',
            'key' => 'project_progress_id'
        ],
        'product' => [
            'Olabs\Oims\Models\ProjectWork', 
            'key' => 'work_id',
            'scope' => 'matchProject'
//            'otherKey' =>'project_id',
            
        ],   
        'work' => [ //to show names
            'Olabs\Oims\Models\ProjectWork', 
            'key' => 'work_id',
//            'scope' => 'matchProject'
//            'otherKey' =>'project_id',
            
        ],
    ];
    
    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_project_progress_items';
    
     /**
     * @var array Guarded fields
     */
    protected $guarded = [];
    
    public function filterFields($fields, $context = null)
    {
        if ($this->product) {
            $fields->unit_price->value = $fields->unit_price->value > 0 ?$fields->unit_price->value : $this->product->unit_price;
//            $fields->unit_price->value = $fields->unit_price->value > 0 ?$fields->unit_price->value : 0;
            $fields->total_price->value = $fields->unit_price->value * $fields->quantity->value;
        }else{
            $fields->unit_price->value = 0;
            $fields->total_price->value = 0;
        }
    }
}