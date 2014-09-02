<?php

namespace Chute;

use Chute\ResultSet\ArrayFactory;
use Chute\Iterator\MapperIterator;
use Traversable;

/**
 * MapReduce knows about all the moving parts specific for Reading, Mapping,
 * Reducing and Writing back.
 *
 * It holds all of these elements as well as the results that is reduced.
 *
 * It will reduce as soon as more than 2 of the same keys are known, this is to
 * make sure the least amount of memory is being used. If you have 2.000.000 elements
 * per key it would be overkill to map 2.000.000 and then loop over to reduce.
 *
 * It also contains convenient methods to do a single map or single reduce. Which is
 * very useful when doing it with a Distributor.
 *
 * @package Chute
 */
class MapReduce implements Mapper, Reducer
{
    private $mapper;
    private $reducer;

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
     * Static constructor in order for more fluid usage in <5.4
     *
     * @param Mapper $mapper
     * @param Reducer $reducer
     */
    public static function create(Mapper $mapper, Reducer $reducer)
    {
        return new static($mapper, $reducer);
    }

    /**
     * @param  Traversable $iterator
     * @return ResultSet
     */
    public function run(Traversable $iterator, ResultSetFactory $factory = null)
    {
        if (null === $factory) {
            $factory = new ArrayFactory;
        }

        $resultSet = $factory->create();
        $iterator  = new MapperIterator($this->mapper, $iterator);

        iterator_apply($iterator, array($this, 'apply'), array($iterator, $resultSet));

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
     * Callbacl for iterator_apply
     *
     * @param Traversable $terator
     * @param ResultSet $resultSet
     */
    private function apply(Traversable $iterator, ResultSet $resultSet)
    {
        if ($item = $iterator->current()) {
            list($key, $value) = $item;

            if ($previous = $resultSet->get($key)) {
                $value = $this->reducer->reduce($value, $previous);
            }

            $resultSet->set($key, $value);
        }

        return true;
    }
}
