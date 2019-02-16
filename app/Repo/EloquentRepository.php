<?php

namespace App\Repo;

use App\Repo\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Auth\Events\Registered;

abstract class EloquentRepository implements Repository
{
    private $app;

    protected $model;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    public function getAll() 
    {
        return $this->model->all();
    }

    public function store(array $attributes)
    {
        $this->model->fill($attributes);
        $this->model->save();
        event(new Registered($this->model));
    }

    function makeModel()
    {
        $this->model = $this->app->make($this->model());
    }

    abstract function model();
}
