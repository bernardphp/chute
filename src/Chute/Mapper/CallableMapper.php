<?php

namespace Chute\Mapper;

/**
 * Proxies the map method to the given callable.
 *
 * @package Chute
 */
class CallableMapper implements \Chute\Mapper
{
    protected $callable;

    /**
     * @param callable $callable
     */
    public function __construct($callable)
    {
        $this->callable = $callable;
    }

    /**
     * {@inheritDoc}
     */
    public function map($item)
    {
        if (PHP_VERSION_ID < 5400 && is_array($this->callable)) {
            return call_user_func($this->callable, $item);
        }

        $callable = $this->callable;

        return $callable($item);
    }
}
