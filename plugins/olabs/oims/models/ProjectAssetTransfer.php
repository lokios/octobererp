<?php namespace Olabs\Oims\Models;

use Model;
use BackendAuth;

/**
 * Model
 */
class ProjectAssetTransfer extends BaseModel
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /*
     * Validation
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_project_asset_transfers';
    
    public $belongsTo = [
        'objectstatus' => [
            'Olabs\Oims\Models\Status', 
            'key' => 'status'
        ],    
        'project' => [
            'Olabs\Oims\Models\Project', 
            'key' => 'project_id'
        ],
        'project_to' => [
            'Olabs\Oims\Models\Project', 
            'key' => 'to_project_id'
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
        //Manage Transfer To Products
        $status = ProjectAsset::syncProjectProductQuantity($this->to_project_id, $this->product_id, $this->unit);
        
        //Manage Transfer From Products
        $status = ProjectAsset::syncProjectProductQuantity($this->project_id, $this->product_id, $this->unit);
    }
}