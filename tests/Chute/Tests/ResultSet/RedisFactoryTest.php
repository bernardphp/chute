<?php

namespace Chute\Tests\ResultSet;

use Chute\ResultSet\RedisFactory;

class RedisFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testItCreatesRedisSet()
    {
        $redis = $this->getMock('Redis');

        $factory = new RedisFactory($redis);

        $this->assertInstanceOf('Chute\ResultSet\RedisSet', $factory->create());
    }
}
