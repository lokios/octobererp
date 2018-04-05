<?php namespace Olabs\Oims\Models;

use Model;
use BackendAuth;
/**
 * Model
 */
class ProjectProgress extends BaseModel
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    const CNAME = 'projectprogress';
    
    
    public function getEntityType()
    {
        return self::CNAME;
    }
    
    protected $dates = ['deleted_at'];

    /*
     * Validation
     */
    public $rules = [
    ];
    
    public $hasMany = [
        'products' => [
            'Olabs\Oims\Models\ProjectProgressItem', 
            'key' => 'project_progress_id'
        ],  
    ];
    
     public $belongsTo = [
        'objectstatus' => [
            'Olabs\Oims\Models\Status', 
            'key' => 'status'
        ],         
        'project' => [
            'Olabs\Oims\Models\Project', 
            'key' => 'project_id'
        ], 
    ];
     
     public $attachMany = [
        'featured_images' => ['System\Models\File', 'order' => 'sort_order'],
        'content_images' => ['System\Models\File']
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_project_progress';
    
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
    
}