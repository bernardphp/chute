<?php

namespace spec\Chute\ResultSet;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArrayFactorySpec extends ObjectBehavior
{
    function it_creates_array_factory()
    {
        $this->create()->shouldHaveType('Chute\ResultSet\ArraySet');
    }
}
