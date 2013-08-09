<?php

namespace Chute\Distributor;

use Chute\MapReduce;
use Iterator;

/**
 * Distributor used for testing only. It Runs every "chunk" in iteration.
 *
 * @package Chute
 */
class SequentialDistributor extends AbstractDistributor
{
    /**
     * {@inheritDoc}
     */
    public function run(MapReduce $mapReduce, Iterator $iterator)
    {
        foreach ($iterator as $batch) {
            $resultSets[] = $this->doRun($mapReduce, $batch);
        }

        return $this->collapse($mapReduce, $resultSets);
    }
}
