<?php

namespace Chute\Distributor;

use Chute\MapReduce;
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
        $resultSet = null;

        foreach ($iterator as $batch) {
            $current = $this->doRun($mapReduce, $batch);

            if ($resultSet) {
                $resultSet->merge($mapReduce, $current);
            } else {
                $resultSet = $current;
            }
        }

        return $resultSet;
    }
}
