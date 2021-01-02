<?php

namespace Api\Core\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * Class BaseModel
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package Api\Core\Base
 */
class BaseModel extends \Eloquent
{
    protected $guarded    = [];
    public    $timestamps = true;

    /**
     * Array to store memoized data
     *
     * @var array
     */
    public $_memoizeArray = [];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // clear memoized on model updates
        static::updated(function ($model) {
            $model->_memoizeArray = [];
        });
    }

    /**
     * Memoization helper. Will compute the result only once
     *
     * @param string   $key
     * @param \Closure $callback
     *
     * @return mixed
     */
    protected function memoize($key, \Closure $callback)
    {
        if (isset($this->_memoizeArray[$key])) {
            return $this->_memoizeArray[$key];
        }

        $result                    = $callback();
        $this->_memoizeArray[$key] = $result;

        return $result;
    }

    /**
     * Reload the current model instance with fresh attributes from the database.
     *
     * @return Model
     */
    public function refresh()
    {
        // clear memoized values
        $this->_memoizeArray = [];

        return parent::refresh();
    }

    /**
     * Get fields from db for update and then update them
     *
     * @param array    $fields
     * @param \Closure $callback
     *
     * @return mixed
     */
    public function forUpdate(array $fields, \Closure $callback)
    {
        $fields = $this->newQuery()
            ->select($fields)
            ->where($this->primaryKey, '=', $this->getKey())
            ->lockForUpdate()
            ->firstOrFail();

        return $callback($this, $fields);
    }
}
