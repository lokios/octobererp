<?php namespace Olabs\Tenant\Models;

use Model;
use Olabs\Tenant\Classes\Tenant;
/**
 * Model
 */
class Contents extends Model
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
    public $table = 'olabs_tenant_contents';

    public $attachMany = [
        'featured_images' => ['System\Models\File', 'order' => 'sort_order'],
        'content_images' => ['System\Models\File']
    ];

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'categories' => ['Olabs\Tenant\Models\ContentCategories', 'table' => 'olabs_tenant_contents_categories']
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

    public function getImage(){
        //$model->avatar->getThumb(100, 100, ['mode' => 'crop']);

        if($this->featured_images){

            foreach($this->featured_images as $fi){

                //return $fi->path;
                return $fi->getThumb(360, 'auto', ['mode' => 'landscape']);
            }
        }

        return false;
    }


    public function getImageMain($fi){


        //return $fi->path;
        return $fi->getThumb(480, 'auto', ['mode' => 'landscape']);


    }
}