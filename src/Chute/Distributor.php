<?php

namespace Chute;

use Iterator;

/**
 * Distributor distributes an iterator out onto a different MapReduce.
 * A Dristributor is used to have forking or threading (async map reduce).
 *
 * @package Chute
 */
interface Distributor
{
    /**
     * @param  MapReduce $mapReduce
     * @param  Iterator $iterator
     * @return ResultSet
     */
    public function run(MapReduce $mapReduce, Iterator $iterator);
}
