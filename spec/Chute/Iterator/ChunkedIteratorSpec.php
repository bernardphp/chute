<?php

namespace spec\Chute\Iterator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ChunkedIteratorSpec extends ObjectBehavior
{
    function it_chunks_iterator()
    {
        $iterator = new \ArrayIterator(array(1, 2, 3));

        $this->beConstructedWith($iterator, 2);

        $this->rewind();

        $this->current()->getArrayCopy()->shouldReturn(array(1, 2));
        $this->current()->shouldHaveType('ArrayIterator');

        $this->next();

        $this->current()->getArrayCopy()->shouldReturn(array(3));
    }
}
