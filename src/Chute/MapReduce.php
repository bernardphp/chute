<?php

namespace Chute;

use Chute\ResultSet\ArraySet;
use Traversable;

/**
 * MapReduce knows about all the moving parts specific for Reading, Mapping,
 * Reducing and Writing back.
 *
 * It holds all of theese elements as well as the results that is reduced.
 *
 * It will reduce as soon as more than 2 of the same keys are known, this is to
 * make sure the least amount of memory is being used. If you have 2.000.000 elements
 * per key it would be overkill to map 2.000.000 and then loop over to reduce.
 *
 * It also contains conveniet methods to do a single map or single reduce. Which is
 * very useful when doing it with a Distributor.
 *
 * @package Chute
 */
class MapReduce implements Mapper, Reducer
{
    protected $mapper;
    protected $reducer;

    /**
     * @param Mapper  $mapper
     * @param Reducer $reducer
     */
    public function __construct(Mapper $mapper, Reducer $reducer)
    {
        $this->mapper = $mapper;
        $this->reducer = $reducer;
    }

    /**
     * @param  Traversable    $iterator
     * @param  ResultSet|null $resultSet
     * @return ResultSet
     */
    public function run(Traversable $iterator, ResultSet $resultSet = null)
    {
        if (!$resultSet) {
            $resultSet = new ArraySet;
        }

        foreach ($iterator as $item) {
            $this->tick($resultSet, $item);
        }

        return $resultSet;
    }

    /**
     * {@inheritDoc}
     */
    public function map($item)
    {
        return $this->mapper->map($item);
    }

    /**
     * {@inheritDoc}
     */
    public function reduce($item, $previous)
    {
        return $this->reducer->reduce($item, $previous);
    }

    /**
     * Maps a single $item and if a previous item with the same key have
     * been mapped thoose two will be reduced together to a single value.
     * This value is then updated in the result set.
     *
     * @param ResultSet $resultSet
     * @param mixed     $item
     */
    protected function tick(ResultSet $resultSet, $item)
    {
        if (null === $value = $this->map($item)) {
            return;
        }

        list($key, $item) = $value;

        if ($previous = $resultSet->get($key)) {
            $item = $this->reduce($item, $previous);
        }

        $resultSet->set($key, $item);
    }
}
