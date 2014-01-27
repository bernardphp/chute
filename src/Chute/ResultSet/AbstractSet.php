<?php

namespace Chute\ResultSet;

use Chute\Reducer;
use Chute\ResultSet;

/**
 * Base for all ResultsSet, if no key is given a uuid will
 * be generated. The key is used to identify a specific run. If it collides
 * it can mean results will be mangled.
 *
 * @package Chute
 */
abstract class AbstractSet implements ResultSet
{
    /**
     * {@inheritDoc}
     */
    public function merge(Reducer $reducer, ResultSet $resultSet)
    {
        foreach ($resultSet->keys() as $key) {
            if ($this->has($key)) {
                $this->set($key, $reducer->reduce($resultSet->get($key), $this->get($key)));
            } else {
                $this->set($key, $resultSet->get($key));
            }
        }
    }
}
