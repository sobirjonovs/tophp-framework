<?php

namespace Core;

interface DatabaseInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function create(array $params);

    /**
     * @return mixed
     */
    public function all();

    /**
     * @param $condition
     * @return mixed
     */
    public function where(array $condition);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @return mixed
     */
    public function get();

    /**
     * @return mixed
     */
    public function first();

    /**
     * @param array $params
     * @return mixed
     */
    public function update(array $params);

    /**
     * @param array|null $condition
     * @return mixed
     */
    public function delete(array $condition);
}