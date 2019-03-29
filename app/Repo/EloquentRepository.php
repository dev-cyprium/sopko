<?php

namespace App\Repo;

use App\Repo\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Auth\Events\Registered;
use App\Repo\DTO\BaseDTO;
use App\Facades\Sopko;

abstract class EloquentRepository implements Repository
{
    private $app;

    /**
     * The eloquent model to work with
     * @var Illuminate\Database\Eloquent\Model;
     */
    protected $model;

    protected $perPage = 15;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->perPage = Sopko::get('per_page');
        $this->makeModel();

        Sopko::observe('per_page', function($new_val) {
            $this->perPage = $new_val;
        });
    }

    public function getAll() 
    {
        return $this->model->all();
    }

    public function setModel($id) 
    {
        $entity = $this->model->find($id);
        $this->model = $entity;
    }

    public function store(array $fillables, array $trusted = []) : object
    {
        $this->model->fill($fillables);
        $this->model->forceFill($trusted);
        $this->model->save();
        $this->afterStore();
        return BaseDTO::intoDTO($this->model);
    }

    public function destroy($id)
    {
        $entity = $this->model->find($id);
        $entity->delete();
    }

    function makeModel()
    {
        $this->model = $this->app->make($this->model());
    }

    /**
     * Before store is empty by default
     */
    protected function afterStore() {}

    abstract function model();
}
