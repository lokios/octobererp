<?php namespace Olabs\Oims\Models;

use Model;
use BackendAuth;
use OlabsAuth;
/**
 * Model
 */
class ProjectAssetMonitor extends BaseModel
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
    public $table = 'olabs_oims_project_asset_monitoring';
    
    public $belongsTo = [
        'objectstatus' => [
            'Olabs\Oims\Models\Status', 
            'key' => 'status'
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
    
    
    /**
     * Get main image
     * 
     * @return type
     */
    public function getMainImage() {
        if (count($this->images) > 0 ) {
            return $this->images[0];
        }
        else {
            $oimsSetting = \Olabs\Oims\Models\Settings::instance();
            if ($oimsSetting->productDefaultImage != null) {
                return $oimsSetting->productDefaultImage;
            }
        }
        
        return null;
    }
    
    /**
     * Get main image path
     * 
     * @return string
     */
    public function getMainImagePath() {
        $mainImage = $this->getMainImage();
        if ($mainImage != null) {
            return $mainImage->path;
        }
        else {
            return "";
        }
    }
    
    public function getImageAttribute()
    {
         $mainImage = $this->getMainImage();
        if ($mainImage != null) {
            return '<img src="'.$this->images[0]->getThumb(50, 50, 'crop').'" />';
        }
        else {
            return "";
        }

    }
}