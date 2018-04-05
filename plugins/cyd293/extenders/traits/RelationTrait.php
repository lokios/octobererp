<?php

namespace Cyd293\Extenders\Traits;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RelationTrait
 *
 * @author cydrick
 */
trait RelationTrait {
    public function isClassExtendedWith($name)
    {
        if($name == 'Backend.Behaviors.RelationController'){
            $name = str_replace('.', '\\', trim($name));
            return isset($this->extensionData['extensions']['Cyd293\Extenders\Behaviors\RelationController']);
        }
        $name = str_replace('.', '\\', trim($name));
        return isset($this->extensionData['extensions'][$name]);
    }
}
