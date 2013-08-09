<?php

namespace Chute;

/**
 * @package Chute
 */
interface Reducer
{
    /**
     * Takes two items that must be compined to a single item with the EXACT
     * same structure and returned.
     *
     * @param  mixed $item
     * @param  mixed $previous
     * @return mixed
     */
    public function reduce($item, $previous);
}
