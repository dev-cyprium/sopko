<?php

namespace App\Repo\DTO;

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

    /**
     * Returns a DTO instance for a given Eloquent object
     * @return BaseDTO
     */
    public static function intoDTO($modelInstance)
    {
        $factory = Factory::make();
        return $factory->intoDTO($modelInstance);
    }
}