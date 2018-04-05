<?php namespace Olabs\Oims\Models;

use Model;
use Lang;

/**
 * Property Model
 */
class Property extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_properties';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];
    
    use \October\Rain\Database\Traits\Validation;
    public $rules = [
        'title' => 'required|between:1,255',
    ];     
    
    /**
     * TranslatableModel
     *
     * @var type 
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = [
        'title',
        'placeholder'
    ];       

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'title',
        'placeholder',
        'required',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
    
    
    public $hasMany = [
      'options' => [
          'Olabs\Oims\Models\PropertyOption',
          'order'      => 'order_index asc',
          ],
    ];

    public function getTypeOptions() {
        return [
            1 => Lang::get('olabs.oims::lang.properties.type_1'),
            2 => Lang::get('olabs.oims::lang.properties.type_2'),
            3 => Lang::get('olabs.oims::lang.properties.type_3'),
            4 => Lang::get('olabs.oims::lang.properties.type_4'),
            5 => Lang::get('olabs.oims::lang.properties.type_5'),
        ];
    }
    
    public function getTypeLabel() {
        $arr = $this->getTypeOptions();
        
        if (array_key_exists($this->type, $arr)) {
            return $arr[$this->type];
        }
        else {
            return $this->type;
        }
    }
    
    /**
     * Get all available options for current product
     * 
     * @param type $product
     * @return type
     */
    public function getCurrentOptions($product) {
        $options = $this->options;

        // check advanced properties
        $productOptions = $product->propertyOptions()->where("property_id", $this->id)->orderBy("order_index", "ASC")->get();
        if (count($productOptions)>0) {
            $options = $productOptions;
        }
        
        return $options;
    }

}