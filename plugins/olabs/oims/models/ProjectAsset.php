<?php namespace Olabs\Oims\Models;

use Model;
use BackendAuth;
use DB;

/**
 * Model
 */
class ProjectAsset extends BaseModel
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
    public $table = 'olabs_oims_project_assets';
    
    public $belongsTo = [
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
    
//    public $attachMany = [
//        'images' => 'System\Models\File',
//        'attachments' => 'System\Models\File',
//    ];
    
    public function beforeCreate() {
//        if($this->status == ''){
//            $this->status = Status::STATUS_NEW;
//        }
        
        $user = BackendAuth::getUser();
        if($this->created_by == ''){
            $this->created_by = $user->id;
        }
        if($this->updated_by == ''){
            $this->updated_by = $user->id;
        }
    }
    
    
    
    public static function syncProjectProductQuantity($project_id, $product_id, $unit){

        /**
        if(!$project_id){
            $project_id = $this->project_id;
        }
        if(!$product_id){
            $product_id = $this->product_id;
        }
        if(!$unit){
            $unit = $this->unit;
        }**/
        
        $assets = DB::select("SELECT product_id, sum(purchase_quantity) as purchase_quantity, sum(tf_quantity) as tf_quantity, sum(tt_quantity) as tt_quantity, sum(damage_quantity) as damage_quantity
FROM (
SELECT product_id, quantity as purchase_quantity, 0 as tf_quantity,0 as  tt_quantity,0 as  damage_quantity FROM `olabs_oims_project_asset_purchases` WHERE project_id = $project_id AND product_id = $product_id
UNION ALL
SELECT product_id, 0 as purchase_quantity, quantity as tf_quantity,0 as  tt_quantity,0 as  damage_quantity FROM `olabs_oims_project_asset_transfers` WHERE to_project_id = $project_id AND product_id = $product_id
UNION ALL
SELECT product_id, 0 as purchase_quantity, 0 as tf_quantity,quantity as  tt_quantity,0 as  damage_quantity FROM `olabs_oims_project_asset_transfers` WHERE project_id = $project_id AND product_id = $product_id
UNION ALL 
SELECT product_id,0 as purchase_quantity, 0 as tf_quantity,0 as  tt_quantity,quantity as  damage_quantity FROM `olabs_oims_project_asset_damages` where project_id = $project_id AND product_id = $product_id
)X
GROUP BY product_id");
        
        foreach($assets as $asset){  
            $quantity = 0;
            $quantity = $asset->purchase_quantity + $asset->tf_quantity - $asset->tt_quantity - $asset->damage_quantity ;
            
            $model = ProjectAsset::where('project_id',$project_id)
                    ->where('product_id',$product_id)
                    ->first();
            
            if(!$model){
                $model = new ProjectAsset;
                $model->product_id = $product_id;
                $model->project_id = $project_id;
            }
            $model->unit = $unit;
            $model->quantity = $quantity;
            $model->save();
        }
        
    }
}