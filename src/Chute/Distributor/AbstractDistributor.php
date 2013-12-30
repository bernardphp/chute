<?php

namespace Chute\Distributor;

use Chute\MapReduce;
use Chute\ResultSetFactory;
use Chute\ResultSet\ArrayFactory;
use Traversable;

/**
 * Abstract class that helps with merging multiple results sets
 * into one.
 *
 * @package Chute
 */
abstract class AbstractDistributor implements \Chute\Distributor
{
    protected $factory;

    public function __construct(ResultSetFactory $factory = null)
    {
        if (null === $factory) {
            $factory = new ArrayFactory;
        }

        $this->factory = $factory;
    }

    /**
     * Will call $mapReduce::run($iterator) for each of the chunks.
     *
     * @param MapReduce   $mapReduce
     * @param Traversable $iterator
     *
     * @return ResultSet
     */
    protected function doRun(MapReduce $mapReduce, Traversable $iterator)
    {
        return $mapReduce->run($iterator, $this->factory);
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
