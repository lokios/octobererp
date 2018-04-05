<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cyd293\Extenders\Classes;

/**
 * Description of EloquentBuilder
 *
 * @author cydrick
 */

use Illuminate\Database\Eloquent\Builder;

class EloquentBuilder extends Builder{
    public function find($id, $columns = array('*'))
    {
            if (is_array($id))
            {
                    return $this->findMany($id, $columns);
            }
            
            if(trait_exists('\Cyd293\Extenders\Database\Traits\CompositeKey')){
                $values = unserialize(base64_decode($id));
                foreach ($this->model->getKeyName(TRUE) as $key => $column){
                    $this->query->where($column, '=', $values[$key]);
                }
            }
            

            return $this->first($columns);
    }
}
