<?php

namespace Chute\ResultSet;

/**
 * InMemory Array implementation for results for small
 * datasets
 *
 * @package Chute
 */
class ArraySet extends AbstractSet
{
    protected $items = array();

    /**
     * {@inheritDoc}
     */
    public function get($group)
    {
        if (isset($this->items[$group])) {
            return $this->items[$group];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function set($group, $value)
    {
        $this->items[$group] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function has($group)
    {
        return isset($this->items[$group]);
    }

    /**
     * {@inheritDoc}
     */
    public function keys()
    {
        return array_keys($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        return $this->items;
    }
}
