<?php

namespace Chute\Distributor;

use Chute\MapReduce;
use Chute\ResultSet\ArraySet;
use Traversable;

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
    public function run(MapReduce $mapReduce, Traversable $iterator)
    {
        $resultSets = array();

        foreach ($iterator as $batch) {
            $resultSets[] = $this->doRun($mapReduce, $batch);
        }

        if ($resultSets) {
            return $this->collapse($mapReduce, $resultSets);
        }

        return new ArraySet;
    }
}
