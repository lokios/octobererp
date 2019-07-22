<?php namespace Olabs\Oims\Models;

use Model;
use DB;
use Lang;
use BackendAuth;
/**
 * Model
 */
class Unit extends BaseModel
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Sluggable;

    protected $dates = ['deleted_at'];

    /**
     * @var array Generate slugs for these attributes.
     */
    protected $slugs = ['slug' => 'name'];
    
    /*
     * Validation
     */
    public $rules = [
        'slug' => [
//            'required',
            'alpha_dash',
            'between:1,255',
            'unique:olabs_oims_units',
        ],      
    ];
    
    protected $primaryKey = 'slug';
    public $incrementing = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_units';
    
    protected $jsonable = ['conversion_meta'];
    
    public function beforeSave()
    {
        // Autogenerate name
//        if (empty($this->name)) {
//            $this->name = $this->make . ' ' . $this->model . ' ' . $this->variant;
//        }

        // Force creation of slug
        if (empty($this->slug)) {
            unset($this->slug);
            $this->setSluggedValue('slug', 'name');
        }
    }
    
    public function getUnitOptions() {
        $list = Unit::select(
                        DB::raw("name, slug")
                )->where('status', '1')->lists('name', 'slug');
        return [null => Lang::get("olabs.oims::lang.plugin.please_select")] + $list;
    }
    
    
    public function getConversions($value){
        $units = $this->getUnitOptions();
//        dd($units);
        $list = [];
        $temp = ['unit'=> $this->slug, 'name' => $this->name, 'value' =>$value, 'conversion' => '1'];
        $list[] = $temp;
        foreach($this->conversion_meta as $meta){
            $temp = ['unit'=> $meta['unit'], 'name' => $units[$meta['unit']], 'value' =>$value * $meta['conversion'], 'conversion' => $meta['conversion']];
            $list[] = $temp;
        }
        return $list;
    }
    
}