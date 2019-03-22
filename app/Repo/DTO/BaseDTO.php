<?php

namespace App\Repo\DTO;

use App\Models\ProductCategory;


abstract class BaseDTO 
{
    /**
     * Serialize all public objects into return
     */
    public function serialize()
    {
        $fields = [];
        $reflect = new \ReflectionClass($this);
        $props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach($props as $prop) {
            $name = $prop->getName();
            $fields[$name] = $prop->getValue($this);
        }

        
        return $fields;
    }

    public static function intoDTO($modelInstance)
    {
        $factory = Factory::make();
        return $factory->intoDTO($modelInstance);
    }
}