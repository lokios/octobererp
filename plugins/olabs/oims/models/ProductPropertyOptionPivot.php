<?php namespace Olabs\Oims\Models;

use October\Rain\Database\Pivot;

/**
 * Product Model
 */
class ProductPropertyOptionPivot extends Pivot
{

    
    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'title',
        'description',
        'price_difference_with_tax',
    ];
    
    protected $jsonable = [];
    
    protected $dates = [];


    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
  
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachMany = [];
    public $attachOne = [
        #'image' => ['System\Models\File'],
    ];     

}