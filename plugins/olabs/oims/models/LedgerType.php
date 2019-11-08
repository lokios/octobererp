<?php

namespace Olabs\Oims\Models;

use Model;
use BackendAuth;
use Lang;

/**
 * Model
 */
class LedgerType extends BaseModel {

    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    use \October\Rain\Database\Traits\Sluggable;

    protected $dates = ['deleted_at'];

    /**
     * @var array Generate slugs for these attributes.
     */
    protected $slugs = ['slug' => 'name'];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'slug' => [
//            'required',
            'alpha_dash',
            'between:1,255',
            'unique:olabs_oims_ledger_types',
        ],
    ];
    protected $primaryKey = 'slug';
    public $incrementing = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_ledger_types';

    public function beforeSave() {

        // Force creation of slug
        if (empty($this->slug)) {
            unset($this->slug);
            $this->setSluggedValue('slug', 'name');
        }
    }
    
    

}
