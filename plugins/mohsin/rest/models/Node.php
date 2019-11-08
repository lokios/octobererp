<?php namespace Mohsin\Rest\Models;

use Model;
use Mohsin\Rest\Classes\ApiManager;

/**
 * Node Model
 */
class Node extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'mohsin_rest_nodes';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var bool If true, node exists in the database but no provider exists.
     */
    public $orphaned = false;

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Jsonable fields
     */
    protected $jsonable = [
        'extras'
    ];

    public function addExtra($key, $value)
    {
        $extras = (array) $this->extras ? [] : $this->extras;
        $extras[$key] = $value;
        $this->extras = $extras;
        $this->save();
    }

    public function removeExtra($key)
    {
        $extras = (array) $this->extras ? [] : $this->extras;
        unset($extras[$key]);
        $this->extras = $extras;
        $this->save();
    }

    public function enable()
    {
        $this->is_disabled = false;
        $this->save();
    }

    public function disable()
    {
        $this->is_disabled = true;
        $this->save();
    }
}
