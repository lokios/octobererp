<?php namespace Olabs\Messaging\Models;

use Model;

/**
 * Model
 */
class CircleMember extends BaseModel
{
    use \October\Rain\Database\Traits\Validation;
    
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    protected $fillable = [
        'user_id',
        'circle_id',
        'username',
        'first_name',
        'last_name',
        'phone_no',
        'email',
        'fcm_token'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_messaging_circle_members';
}
