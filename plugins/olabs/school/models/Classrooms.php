<?php namespace Olabs\School\Models;

use Model;

/**
 * Model
 */
class Classrooms extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
    ];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = true;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_school_classes';

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'subjects' => ['Olabs\School\Models\Subjects', 'table' => 'olabs_school_class_subjects']
    ];
}