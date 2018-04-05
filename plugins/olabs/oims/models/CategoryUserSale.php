<?php namespace Olabs\Oims\Models;

use Model;
use DB;


/**
 * CategoryUserSale Model
 */
class CategoryUserSale extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_categories_users_sale';

    
    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'sale' => 'required|numeric',
        'category_id' => [
            'required'
        ],
        'user_id' => [
            'required',
        ],        
    ];
    
    public function beforeValidate() {
        $this->rules["user_id"] =
            [
            'required',
            'unique:olabs_oims_categories_users_sale,user_id,'.$this->user_id.',created_at,category_id,'.$this->category_id,
        ];
    }     
    
    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'category',
        'user',
        'sale',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
    ];
    public $belongsTo = [
        'category' => [
            'Olabs\Oims\Models\Category', 
            'key' => 'category_id'
        ],        
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
    ];

     
    public function getUserOptions()
    {
        if (class_exists("\RainLab\User\Models\User")) {
             return \RainLab\User\Models\User::select(
                    DB::raw("CONCAT_WS(' ', id, '|', name, surname) AS full_name, id")
                    )->lists('full_name', 'id');
        }
        else {
            return [
                null => "Firstly install Rainlab User plugin"
            ];
        }
    }    
}