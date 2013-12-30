<?php

namespace Chute\Reducer;

/**
 * Proxies the reduce method to the given callable.
 *
 * @package Chute
 */
class CallableReducer implements \Chute\Reducer
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
    public function reduce($item, $previous)
    {
        if (PHP_VERSION_ID < 5400 && is_array($this->callable)) {
            // This is ridicoulously slow.
            return call_user_func($this->callable, $item, $previous);
        }

        $callable = $this->callable;

        return $callable($item, $previous);
    }
}
