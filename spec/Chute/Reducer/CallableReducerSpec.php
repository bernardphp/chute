<?php

namespace spec\Chute\Reducer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CallableReducerSpec extends ObjectBehavior
{
    function it_delegates_to_callable()
    {
        $callable = function ($item, $previous) {
            return $item * $previous;
        };

        $this->beConstructedWith($callable);

        $this->reduce(2, 6)->shouldReturn(12);
    }
}
