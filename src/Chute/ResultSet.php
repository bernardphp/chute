<?php

namespace Chute;

/**
 * ResultSet of map reduce
 *
 * @package Chute
 */
interface ResultSet extends \Countable
{
    /**
     * @param  string $group
     * @return mixed
     */
    public function get($group);

    /**
     * @param string $group
     * @param mixed  $value
     */
    public function set($group, $value);

    /**
     * @param  string  $group
     * @return boolean
     */
    public function has($group);

    /**
     * @return string[]
     */
    public function keys();

    /**
     * @return mixed[string]
     */
    public function all();

    /**
     * @param Reducer   $reducer
     * @param ResultSet $resultSet
     */
    public function merge(Reducer $reducer, ResultSet $resultSet);
}
