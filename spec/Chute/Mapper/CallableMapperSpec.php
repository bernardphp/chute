<?php

namespace spec\Chute\Mapper;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CallableMapperSpec extends ObjectBehavior
{
    function it_delegates_to_callable()
    {
        $callable = function ($value) {
            return array('group', $value * 2);
        };

        $this->beConstructedWith($callable);

        $this->map(2)->shouldReturn(array('group', 4));
    }
}
