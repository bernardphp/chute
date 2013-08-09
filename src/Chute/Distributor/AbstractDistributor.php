<?php

namespace Chute\Distributor;

use Chute\ResultSet;
use Chute\MapReduce;
use Iterator;

/**
 * Abstract class that helps with merging multiple results sets
 * into one.
 *
 * @package Chute
 */
abstract class AbstractDistributor implements \Chute\Distributor
{
    /**
     * {@inheritDoc}
     */
    abstract public function run(MapReduce $mapReduce, Iterator $iterator);

    /**
     * Will call $mapReduce::run($iterator) for each of the chunks.
     *
     * @param MapReduce $mapReduce
     * @param Iterator  $iterator
     */
    protected function doRun(MapReduce $mapReduce, Iterator $iterator)
    {
        return $mapReduce->run($iterator);
    }

    /**
     * Takes an array of ResultSet's and collapses them into one by merging
     * them.
     *
     * @param  MapReduce   $mapReduce
     * @param  ResultSet[] $resultSets
     * @return ResultSet
     */
    protected function collapse(MapReduce $mapReduce, array $resultSets)
    {
        $resultSet = array_pop($resultSets);

        while ($set = array_pop($resultSets)) {
            $resultSet->merge($mapReduce, $set);
        }

        return $resultSet;
    }
}
