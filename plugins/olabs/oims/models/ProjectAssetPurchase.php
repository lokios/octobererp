<?php namespace Olabs\Oims\Models;

use Model;
use BackendAuth;

/**
 * Model
 */
class ProjectAssetPurchase extends BaseModel
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;
    
//    use \Olabs\Tenant\Classes\MultiTenantTrait;

    protected $dates = ['deleted_at'];
    
    /*
     * Validation
     */
    public $rules = [
    ];
    
    public $purchase_quantity;
    public $damage_quantity;
    public $tf_quantity;
    public $tt_quantity;
    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_project_asset_purchases';
    
    public $belongsTo = [
        'objectstatus' => [
            'Olabs\Oims\Models\Status', 
            'key' => 'status'
        ],    
        'purchase' => [
            'Olabs\Oims\Models\Purchase', 
            'key' => 'purchase_id'
        ],
        'project' => [
            'Olabs\Oims\Models\Project', 
            'key' => 'project_id'
        ],
        'unit_code' => [
            'Olabs\Oims\Models\Unit', 
            'key' => 'unit'
        ],
        'product' => [
            'Olabs\Oims\Models\Product', 
            'key' => 'product_id'
        ],   
    ];
    
    public $attachMany = [
        'images' => 'System\Models\File',
        'attachments' => 'System\Models\File',
    ];
    
    public function beforeCreate() {
        if($this->status == ''){
            $this->status = Status::STATUS_NEW;
        }
        
        $user = BackendAuth::getUser();
        if($this->created_by == ''){
            $this->created_by = $user->id;
        }
        if($this->updated_by == ''){
            $this->updated_by = $user->id;
        }
    }
    
    public function afterSave(){
        //Manage Purchase Products
        $status = ProjectAsset::syncProjectProductQuantity($this->project_id, $this->product_id, $this->unit);
    }
    
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
}