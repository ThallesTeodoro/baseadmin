<?php

namespace ThallesTeodoro\BaseAdmin\App\Interfaces;

use stdClass;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    /**
     * Return an item with defined id
     *
     * @param integer $id
     * @return stdClass|null
     */
    function getById(int $id) : ?stdClass;

    /**
     * Return all rows from database
     *
     * @return Collection
     */
    function all() : Collection;

    /**
     * Add a new item to database
     *
     * @param array $data
     * @return stdClass|null
     */
    function add(array $data) : ?stdClass;

    /**
     * Update an item in database
     *
     * @param integer $id
     * @param array $data
     * @return stdClass|null
     */
    function update(int $id, array $data) : ?stdClass;

    /**
     * Delete an item from database
     *
     * @param integer $id
     * @return boolean
     */
    function delete(int $id) : bool;

    /**
     * Return total of items in database
     *
     * @return integer
     */
    function count() : int;
}
