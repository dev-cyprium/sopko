<?php

namespace App\Repo;

use App\Repo\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Auth\Events\Registered;
use App\Repo\DTO\BaseDTO;

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

    public function store(array $fillables, array $trusted = []) : object
    {
        $this->model->fill($fillables);
        $this->model->forceFill($trusted);
        $this->model->save();
        return BaseDTO::intoDTO($this->model);
    }

    function makeModel()
    {
        $this->model = $this->app->make($this->model());
    }

    abstract function model();
}
