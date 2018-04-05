<?php namespace Olabs\Tenant\Models;

use Model;

/**
 * Model
 */
class Organizations extends Model
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
    public $table = 'olabs_tenant_organizations';

    public $attachMany = [
        'featured_images' => ['System\Models\File', 'order' => 'sort_order'],
        'content_images' => ['System\Models\File']
    ];


    public function getImageMain($fi){


                //return $fi->path;
                return $fi->getThumb(480, 'auto', ['mode' => 'landscape']);


    }
}