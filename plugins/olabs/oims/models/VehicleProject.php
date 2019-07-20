<?php namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class VehicleProject extends Model
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

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'projects' => ['Olabs\Oims\Models\Project', 'table' => 'olabs_oims_vehicle_projects'],
        'project_count' => ['Olabs\Oims\Models\Project', 'table' => 'olabs_oims_vehicle_projects', 'count' => true]
    ];
    
    public $belongsTo = [
        'project' => ['Olabs\Oims\Models\Project']
    ];
    
    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_vehicle_projects';
    
//    public function afterCreate()
//    {
//        if ($this->is_new_user_default) {
//            $this->addAllUsersToProject();
//        }
//    }
//
//    public function addAllUsersToProject()
//    {
//        $this->projects()->sync(User::lists('id'));
//    }
}