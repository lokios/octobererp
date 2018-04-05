<?php namespace Olabs\Principles\Models;

use Model;
use Olabs\Tenant\Classes\Tenant;
/**
 * Model
 */
class Principles extends Model
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
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_principles_';

    /*
    * Relations
    */
    public $belongsTo = [
        'user' => ['Backend\Models\User']
    ];

    public $belongsToMany = [
        'categories' => [
            'RainLab\Blog\Models\Category',
            'table' => 'rainlab_principles_categories',
            'order' => 'name'
        ]
    ];

    public $attachMany = [
        'featured_images' => ['System\Models\File', 'order' => 'sort_order'],
        'content_images' => ['System\Models\File']
    ];

    public function save(array $options = NULL, $sessionKey = NULL)
    {
      /*  $org = Tenant::getOrg();
        if($org){
            $this->tenant_id = $org->id;
        }*/
        $this->tenant_id = Tenant::getUserOrgId();
        // before save code
        parent::save($options,$sessionKey);
        // after save code
    }

}