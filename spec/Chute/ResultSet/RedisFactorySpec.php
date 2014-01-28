<?php

namespace spec\Chute\ResultSet;

use PhpSpec\ObjectBehavior;
use PhpSpec\Exception\Example\PendingException;

class RedisFactorySpec extends ObjectBehavior
{
    function let($redis)
    {
        // PhpSpec does not have a real skipped state and until
        // #119 is cleared this will have to work.
        if (!extension_loaded('redis')) {
            throw new PendingException();
        }

        $redis->beADoubleOf('Redis');

        $this->beConstructedWith($redis);
    }

    function it_creates_redis_set()
    {
        $this->create()->shouldHaveType('Chute\ResultSet\RedisSet');
    }
}
