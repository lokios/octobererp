<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cyd293\Extenders\Database;

/**
 * Description of Model
 *
 * @author cydrick
 */
use October\Rain\Database\Model as BaseModel;
use October\Rain\Database\Relations\HasMany;

class Model extends BaseModel{
    public function hasMany($related, $primaryKey = null, $localKey = null, $relationName = null)
    {
        if (is_null($relationName))
            $relationName = $this->getRelationCaller();

        $primaryKey = $primaryKey ?: $this->getForeignKey();
        $localKey = $localKey ?: $this->getKeyName();
        $instance = new $related;

        $object = new HasMany($instance->newQuery(), $this, $instance->getTable().'.'.$primaryKey, $localKey, $relationName);
        
        return $object->setQuery($instance->newQuery()->where('ptr_type','dadas'));
    }
}
