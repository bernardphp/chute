<?php

namespace Chute\ResultSet;

use Chute\Reducer;
use Chute\ResultSet;
use Chute\Util\Generator;

/**
 * Base for all ResultsSet, if no key is given a uuid will
 * be generated. The key is used to identify a specific run. If it collides
 * it can mean results will be mangled.
 *
 * @package Chute
 */
abstract class AbstractSet implements ResultSet
{
    protected $key;

    /**
     * @param mixed|null $key
     */
    public function __construct($key = null)
    {
        if (!$key) {
            $key = Generator::generateUuid();
        }

        $this->key = $key;
    }

    /**
     * {@inheritDoc}
     */
    public function merge(Reducer $reducer, ResultSet $resultSet)
    {
        foreach ($resultSet->keys() as $key) {
            if ($this->has($key)) {
                $this->set($key, $reducer->reduce($this->get($key), $resultSet->get($key)));
            } else {
                $this->set($key, $resultSet->get($key));
            }
        }
    }
}
