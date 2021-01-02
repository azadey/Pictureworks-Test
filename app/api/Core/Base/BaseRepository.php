<?php

namespace Api\Core\Base;

use Eloquent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator as LengthAwarePaginatorImpl;


abstract class BaseRepository
{
    /**
     * @var Eloquent|Builder
     */
    protected $model;

    /**
     * Table name for this model
     *
     * @var string
     */
    protected $tableName;

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->makeModel();
        $this->tableName = $this->model->getTable();
    }

    /**
     * Get the model the repository is for
     *
     * @return string
     */
    abstract public function model();

    /**
     * Make the model
     *
     * @return Model|mixed
     * @throws \Exception
     */
    private function makeModel()
    {
        $model = app($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * @param Builder $query
     * @param array   $order
     *
     * @return Builder
     */
    protected function setOrderBy(Builder $query, $order = [])
    {
        if (!empty($order)) {
            if (count($order) == 2) {
                $query = $query->orderBy($order[0], $order[1]);
            } else {
                $query = $query->orderBy($order[0]);
            }
        }

        return $query;
    }

    /**
     * Create a new query
     *
     * @return Builder|QueryBuilder
     */
    public function query()
    {
        return $this->model->newQuery();
    }

    /**
     * Get all values
     *
     * @param array $with
     *
     * @return LengthAwarePaginator|Collection
     */
    public function all($with = [])
    {
        $query = $this->query()
            ->with($with);

        return $query->get();
    }

    /**
     * All results chunked
     *
     * @param int      $count
     * @param \Closure $closure
     * @param array    $with
     *
     * @return bool
     */
    public function allChunk($count, \Closure $closure, $with = [])
    {
        return $this->query()
            ->with($with)
            ->chunk($count, $closure);
    }

    /**
     * Create a model instance
     *
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a model
     *
     * @param Model $model
     * @param array $data
     *
     * @return bool did the operation succeed
     */
    public function update(Model $model, array $data)
    {
        return $model->update($data);
    }

    /**
     * Delete a model
     *
     * @param Model $model
     *
     * @return bool did the operation succeed
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }

    /**
     * @param       $id
     * @param array $columns
     *
     * @return Model|null|mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    /**
     * Find a model or fail
     *
     * @param mixed $id
     * @param array $columns columns to select
     * @param array $with
     *
     * @return mixed
     */
    public function findOrFail($id, $columns = ['*'], $with = [])
    {
        return $this->model->query()->with($with)->findOrFail($id, $columns);
    }

    /**
     * Find model by given key and value or fail
     *
     * @param string $key
     * @param mixed  $value
     * @param array  $columns
     * @param array  $with
     *
     * @return Model|static
     */
    public function findByOrFail($key, $value, $columns = ['*'], $with = [])
    {
        return $this->query()
            ->with($with)
            ->where($key, '=', $value)
            ->firstOrFail($columns);
    }

    /**
     * Find a model with relations loaded
     *
     * @param int          $id id
     * @param string|array $withColumns
     * @param array        $columns
     *
     * @return mixed
     */
    public function findWith($id, $withColumns, $columns = ['*'])
    {
        return $this->model->with($withColumns)->find($id, $columns);
    }

    /**
     * @param       $attribute
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = ['*'])
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     *
     * @param       $attribute
     * @param       $value
     * @param       $withColumns
     * @param array $columns
     *
     * @return Eloquent
     */
    public function findByWith($attribute, $value, $withColumns, $columns = ['*'])
    {
        return $this->model->with($withColumns)->where($attribute, '=', $value)->first($columns);
    }

    /**
     * Where In
     *
     * @param       $attribute
     * @param       $values
     * @param array $with
     * @param array $orderBy
     *
     * @return LengthAwarePaginator|Collection
     * @throws \Api\Exceptions\InvariantViolationException
     */
    public function getIn($attribute, $values, $with = [], $orderBy = [])
    {
        $query = $this->query()
            ->with($with)
            ->whereIn($attribute, $values);

        $query = $this->setOrderBy($query, $orderBy);

        return $query->get();
    }

    /**
     * Create a paginator from items
     *
     * @param $items
     *
     * @return LengthAwarePaginator
     */
    public function paginator($items)
    {
        $limit = request()->get('limit', 20);
        $page  = request()->get('page', 1);

        $offset = ($page * $limit) - $limit;

        return new LengthAwarePaginatorImpl(
            array_slice($items, $offset, $limit, true),
            count($items),
            $limit,
            $page,
            [
                'path'  => request()->url(),
                'query' => request()->query(),
            ]
        );
    }

    /**
     * Throw a not found exception
     *
     * @param array $ids
     */
    public function throwNotFound($ids = [])
    {
        throw (new ModelNotFoundException)->setModel($this->model(), $ids);
    }
}
