<?php

namespace spec\Chute\Iterator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MapperIteratorSpec extends ObjectBehavior
{
    /**
     * @param Chute\Mapper $mapper
     */
    function it_maps_value_returned_from_iterator($mapper)
    {
        $iterator = new \ArrayIterator(array(1, 2));

        $this->beConstructedWith($mapper, $iterator);

        $mapper->map(1)->willReturn(array('odd', 1));
        $mapper->map(2)->willReturn(array('even', 2));

        // first iterator also make sure current just gets the same
        // variable.
        $this->rewind();
        $this->current()->shouldReturn(array('odd', 1));
        $this->current()->shouldReturn(array('odd', 1));

        $this->next();
        $this->current()->shouldReturn(array('even', 2));
    }
}
