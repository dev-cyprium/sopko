<?php

namespace App\Repo\DTO;

use Illuminate\Support\Collection;


abstract class BaseDTO 
{
    protected $unused = [];

    /**
     * Serialize all public objects into return
     */
    public function serialize()
    {
        $fields = [];
        $reflect = new \ReflectionClass($this);
        $props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach($props as $prop) {
            $val = $prop->getValue($this);
            $name = $prop->getName();

            if(in_array($prop->getName(), $this->unused)) {
                continue;
            }

            if(is_array($val) && $this->isAssoc($val)) {
                collect($val)->map(function($val, $key) use (&$fields) {
                    $fields[$key] = $val;
                });
            } else if(is_array($val) || $val instanceof Collection) {
                collect($val)->map(function($v) use ($name, &$fields) {
                    if(!isset($fields[$name])) {
                        $fields[$name] = [];
                    }
                    
                    if($v instanceof BaseDTO) {
                        $localFields = $v->serialize();
                        $obj = [];
                        foreach($localFields as $k => $v) {
                            $obj[$k] = $v;
                        }
                        $fields[$name][] = $obj;
                    } else {
                        $fields[$name][] = $v;
                    }
                });
            } else if($val instanceof BaseDTO) {
                $localFields = $val->serialize();
                foreach($localFields as $k => $v) {
                    $fields[$name][$k] = $v;    
                }
            } else {
                $fields[$name] = $prop->getValue($this);
            }

        }
        
        return $fields;
    }

    /**
     * Ignore a field durning rendering of the DTO
     * handfull when you have several fields that
     * exclude one or other.
     */
    public function ignore(string $field) 
    {
        $this->unused[] = $field;
    }

    /**
     * Returns weather or not a given array is associative
     */
    function isAssoc($arr)
    {
        if($arr instanceof Collection) return false;
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }


    /**
     * Returns a DTO instance for a given Eloquent object
     * @return BaseDTO
     */
    public static function intoDTO($modelInstance, $flags = [])
    {
        $factory = AutoMapper::make();
        return $factory->intoDTO($modelInstance, null, $flags);
    }
}