<?php

namespace ThallesTeodoro\BaseAdmin\App\Repositories;

use stdClass;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use ThallesTeodoro\BaseAdmin\App\Interfaces\RepositoryInterface;

class Repository implements RepositoryInterface
{
    /**
     * Repository model
     *
     * @var Model
     */
    protected $model;

    /**
     * Contructor method
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Return an item with defined id
     *
     * @param integer $id
     * @return stdClass|null
     */
    public function getById(int $id) : ?stdClass
    {
        $item = $this->model->find($id);

        if ($item != null) {
            $item = $item->toArray();
            $item = $this->arrayToStdClass($item);
        } else {
            $item = null;
        }

        return $item;
    }

    /**
     * Return all rows from database
     *
     * @return Collection
     */
    public function all() : Collection
    {
        $items = $this->model
            ->all()
            ->toArray();
        $items = $this->arrayToStdClass($items);
        $items = new Collection($items);

        return $items;
    }

    /**
     * Add a new item to database
     *
     * @param array $data
     * @return stdClass|null
     */
    public function add(array $data) : ?stdClass
    {
        $item = $this->model
            ->create($data)
            ->toArray();
        $item = $this->arrayToStdClass($item);

        return $item;
    }

    /**
     * Update an item in database
     *
     * @param integer $id
     * @param array $data
     * @return stdClass|null
     */
    public function update(int $id, array $data) : ?stdClass
    {
        $item = $this->model->find($id);

        if ($item != null) {
            $item->update($data);
            $item = $item->toArray();
            $item = $this->arrayToStdClass($item);
        } else {
            $item = null;
        }

        return $item;
    }

    /**
     * Delete an item from database
     *
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id) : bool
    {
        $item = $this->model->find($id);

        if ($item != null) {
            $item->delete();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Return total of items in database
     *
     * @return integer
     */
    public function count() : int
    {
        return $this->model->count();
    }

    /**
     * Convert array to stdClass
     *
     * @param array $array
     * @return stdClass
     */
    protected function arrayToStdClass(array $array) : stdClass
    {
        $object = new stdClass();

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (isset($value[0]) && is_array($value[0])) {
                    $value = $this->arrayToStdClass($value);
                    $value = new Collection($value);
                } else {
                    if (count($value) > 0) {
                        $value = $this->arrayToStdClass($value);
                    } else {
                        $value = null;
                    }
                }
            }
            $object->$key = $value;
        }

        return $object;
    }
}
