<?php

namespace Chute;

use Traversable;

/**
 * Distributor distributes an iterator out onto a different MapReduce.
 * A Distributor is used to have forking or threading (async map reduce).
 *
 * @package Chute
 */
interface Distributor
{
    /**
     * @param  MapReduce   $mapReduce
     * @param  Traversable $iterator
     * @return ResultSet
     */
    public function run(MapReduce $mapReduce, Traversable $iterator);
}
