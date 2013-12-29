<?php

namespace Chute\Util;

use Chute\Mapper;
use Traversable;

class MapperIterator extends \IteratorIterator
{
    protected $mapper;
    protected $iterator;

    public function __construct(Mapper $mapper, Traversable $iterator)
    {
        parent::__construct($iterator);

        $this->mapper = $mapper;
    }

    public function current()
    {
        return $this->mapper->map(parent::current());
    }
}
