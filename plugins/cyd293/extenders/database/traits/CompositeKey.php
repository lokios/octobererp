<?php

namespace Cyd293\Extenders\Database\Traits;

use Cyd293\Extenders\Classes\EloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Exception;

trait CompositeKey {
    
    //use \October\Rain\Extension\ExtendableTrait;
    
    /**
     * Composite Key Name
     * @var string
     * 
     * protected $compositeKey = '';
     */
    
    public static function bootCompositeKey(){
        if(!property_exists(get_called_class(), 'compositeKey')){
            throw new Exception(sprintf('You must define a $compositeKey property in %s to use the CompositeKey trait.', get_called_class()));
        }
        
        static::extend(function($model){
            if(!is_array($model->primaryKey))
                $model->primaryKey = [$model->primaryKey];
            
            $model->addDynamicMethod(camel_case('get_'. $model->getKeyName() . '_attribute'),function() use($model){
                return $model->getKey();
            });
        });
        
    }
    
    public function newEloquentBuilder($query)
    {
            return new EloquentBuilder($query);
    }
    
    public function getKeyName($in_array = FALSE){
        if($in_array) return $this->primaryKey;
        return $this->compositeKey;
    }
    
    public function getKey($key = null){
        if(is_null($key)){
            $values = [];
            foreach($this->primaryKey as $column){
                $values[] = $this->getAttribute($column);
            }

            return base64_encode(serialize($values));
        }elseif(in_array($key, $this->primaryKey)){
            return $this->getAttribute($column);
        }
        throw new Exception(sprintf('The %s is not exist in composite primary key.', $key));
    }
    
    public function getAttributes(){
        return array_merge($this->attributes, [
            $this->compositeKey => $this->getKey()
        ]);
    }
    
    protected function setKeysForSaveQuery(Builder $query)
    {
        foreach($this->primaryKey as $column){
            $query->where($column, '=', $this->getKeyForSaveQuery($column));
        }
        
        return $query;
    }
    
    protected function getKeyForSaveQuery($key = null)
    {
        if(is_null($key)){
            if (isset($this->original[$this->getKeyName()]))
            {
                    return $this->original[$this->getKeyName()];
            }

            return $this->getAttribute($this->getKeyName());
        }
        else {
            if (isset($this->original[$key]))
            {
                    return $this->original[$key];
            }

            return $this->getAttribute($key);
        }
    }
    
}