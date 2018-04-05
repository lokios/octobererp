<?php namespace Olabs\Oims\Models;

use Model;

/**
 * PropertyOption Model
 */
class PropertyOption extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_property_options';
    
    use \October\Rain\Database\Traits\Validation;
    public $rules = [
        'title' => 'required|between:1,255',
    ];     
    

    /**
     * TranslatableModel
     * 
     * !!be carefully - @RainLab.Translate don't support relation from backend, but if you add translations into table works fine
     *
     * @var type 
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = [
        'title'
    ]; 
    
    
    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'title'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
    
    public $belongsTo = [
      'property' => ['Olabs\Oims\Models\Property'],
    ];    
    
    public function beforeCreate()
    {
        $this->order_index = $this::where('property_id',$this->property_id)->max('order_index')+1;
    }     

}