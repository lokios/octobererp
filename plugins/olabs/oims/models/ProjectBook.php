<?php

namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class ProjectBook extends BaseModel {

    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];
    
    const CNAME = 'purchases';
    
    public function getEntityType()
    {
        return self::CNAME;
    }
    
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    public $belongsTo = [
        'project' => [
            'Olabs\Oims\Models\Project',
            'key' => 'project_id'
        ],
//        'objectstatus' => [
//            'Olabs\Oims\Models\Status',
//            'key' => 'status'
//        ],
    ];
    
    public $attachMany = [
        'attachments' => ['System\Models\File', 'order' => 'sort_order'],
//        'content_images' => ['System\Models\File']
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_project_books';

    
    public function getBookTypeOptions($activeOnly = false) {
        $options = [
            'material_receipt' => 'Material Receipt',
        ];

        return $options;
    }
    
    public function getBookType(){
        $list = $this->getBookTypeOptions();
        return isset($list[$this->book_type]) ? $list[$this->book_type] : $this->book_type;
    }

}
