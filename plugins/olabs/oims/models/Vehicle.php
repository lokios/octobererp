<?php namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class Vehicle extends BaseModel
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];
    
    const CNAME = 'vehicle';
    
    public function getEntityType()
    {
        return self::CNAME;
    }

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_vehicles';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'reference_number' => [
            'required',
            'alpha_dash',
            'between:1,255',
            'unique:olabs_oims_vehicles',
        ],
    ];
    
    public $attachMany = [
        'attachments' => ['System\Models\File', 'order' => 'sort_order'],
//        'content_images' => ['System\Models\File']
    ];
    
    public $belongsTo = [
//        'purchase' => [
//            'Olabs\Oims\Models\Purchase',
//            'key' => 'purchase_id'
//        ],
//        'product' => [
//            'Olabs\Oims\Models\Product', 
//            'key' => 'product_id'
//        ],   
        'unit_code' => [
            'Olabs\Oims\Models\Unit', 
            'key' => 'unit'
        ],
//        'tax' => [
//            'Olabs\Oims\Models\Tax', 
//            'key' => 'tax_id'
//        ],
//        'objectstatus' => [
//            'Olabs\Oims\Models\Status',
//            'key' => 'status'
//        ],
    ];
    
    public $belongsToMany = [
        'projects' => [
            'Olabs\Oims\Models\Project', 
            'table' => 'olabs_oims_vehicle_projects', 
            'conditions' => 'status=1',
//            'scope' => 'matchPurchase'
        ],

    ];
    
    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];
    
    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'vehicle_type',
        'reference_number',
        'name',
        'model',
        'context_date',
        'status',
        'unit_code',
        'length',
        'width',
        'height',
        'description',
        'attachments',
        'projects',
        
    ];
    
    public function getVehicleTypeOptions($activeOnly = false) {
        $options = [
            'supplier' => 'Supplier',
            'purchased' => 'Purchased',
            'lease' => 'On Lease',
        ];

        return $options;
    }
    
    public function getVehicleType(){
        $list = $this->getVehicleTypeOptions();
        return isset($list[$this->vehicle_type]) ? $list[$this->vehicle_type] : $this->vehicle_type;
    }
    
}
