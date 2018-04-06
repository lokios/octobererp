<?php namespace Olabs\Social\Models;

use Model;

/**
 * Model
 */
class EntityRelations extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Validation
     */
    public $rules = [
    ];
protected $jsonable = ['data'];
    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_social_entity_relations';
}