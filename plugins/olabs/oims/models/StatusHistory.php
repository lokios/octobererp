<?php

namespace Olabs\Oims\Models;

use Model;
use BackendAuth;

/**
 * Model
 */
class StatusHistory extends Model {

    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */

    public $rules = [
    ];
    
    
    public $belongsTo = [
        'createdBy' => [
            'Backend\Models\User',
            'key' => 'created_by'
        ],
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_status_history';

    public function _statusChange($object) {

        $model = new StatusHistory();
        $model->entity_id = $object->id;
        $model->entity_type = $object->getEntityType();
        $model->status = $object->status;
        $model->comment = $object->comment;
        $model->save();
        return $model;
    }
    
    public function _recordUpdated($object) {

        $model = new StatusHistory();
        $model->entity_id = $object->id;
        $model->entity_type = $object->getEntityType();
        $model->status = 'updated';
        $model->comment = $object->comment;
        $model->save();
        return $model;
    }

    public function beforeCreate() {

        $user = BackendAuth::getUser();
        if ($this->created_by == '') {
            $this->created_by = $user->id;
        }
        if ($this->updated_by == '') {
            $this->updated_by = $user->id;
        }
    }

    public function beforeUpdate() {

        $user = BackendAuth::getUser();
        if ($this->updated_by == '') {
            $this->updated_by = $user->id;
        }
    }

}
