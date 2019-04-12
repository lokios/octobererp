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
    
    const CNAME = 'project_book';
    
    public function getEntityType()
    {
        return self::CNAME;
    }
    
    /**
     * @var array Validation rules
     */
    public $rules = [
        'series_from' => 'numeric|required',
        'series_to' => 'numeric|required',
        'leaf_count' => 'numeric|required',
        'leaf_balance' => 'numeric|required',
        
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
            'purchases' => 'Material Receipt',
        ];

        return $options;
    }
    
    public function getBookType(){
        $list = $this->getBookTypeOptions();
        return isset($list[$this->book_type]) ? $list[$this->book_type] : $this->book_type;
    }
    
    public function filterFields($fields, $context = null)
    {
        $series_from = $fields->series_from->value > 0 ? $fields->series_from->value - 1 : 0;
        $series_to = $fields->series_to->value > 0 ? $fields->series_to->value : 0;
        
        
        $leaf_count = $series_to - $series_from;
        
        if($leaf_count > 0){
            $fields->leaf_count->value = $leaf_count;
        
            //Calculate Leaf Balance
            if($this->id){
                $count_lead_used = $this->getModal($this->book_type)->where('project_book_id', $this->id)->count(); 
                $fields->leaf_balance->value = $leaf_count - $count_lead_used;
            }else{
                $fields->leaf_balance->value = $leaf_count;
            }
        }
        
        
        
    }

}
