<?php

namespace App\Repo\DTO;

use App\Models\ProductCategory;


class Factory
{
    private static $instance = null;

    protected $bindings = [
        ProductCategory::class => 'productCategory'
    ];

    public static function make()
    {
        if(self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function intoDTO($modelInstance) {
        $class = get_class($modelInstance);

        if(array_key_exists($class, $this->bindings)) {
            $method = $this->bindings[$class];
            return $this->{$method}($modelInstance);
        } else {
            return $modelInstance;
        }
    }

    private function productCategory($model)
    {
        $dto = new CategoryDTO;
        $dto->id = $model->id;
        $dto->parent_category_id = $model->parent_id;
        $dto->title = $model->title;
        return $dto;
    }
}