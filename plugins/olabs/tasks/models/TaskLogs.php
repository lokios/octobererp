<?php namespace Olabs\Tasks\Models;

use Model;

/**
 * Model
 */
class TaskLogs extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Validation
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_tasks_logs';
}