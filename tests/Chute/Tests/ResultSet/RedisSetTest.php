<?php

namespace Chute\Tests\ResultSet;

use Chute\ResultSet\RedisSet;
use Redis;

class RedisSetTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->redis = $this->getMock('Redis');
        $this->set = new RedisSet($this->redis);
    }

    public function testKeyIsUuidV4()
    {
        $this->assertRegExp('/([a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12})/', (string) $this->set);
    }

    public function testItIsASet()
    {
        $this->assertInstanceOf('Chute\ResultSet', $this->set);
    }

    public function testItIsCountable()
    {
        $this->redis->expects($this->once())->method('hkeys')
            ->will($this->returnValue(array('key1', 'key2')));

        $this->assertInstanceOf('Countable', $this->set);
        $this->assertCount(2, $this->set);
    }

    public function testItGetsKeys()
    {
        $this->redis->expects($this->once())->method('hkeys')
            ->with($this->set)->will($this->returnValue(array('key1', 'key2')));

        $this->assertEquals(array('key1', 'key2'), $this->set->keys());
    }

    public function testItCheckExistenceOfGroup()
    {
        $this->redis->expects($this->once())->method('hexists')
            ->with($this->set, 'key1')->will($this->returnValue(true));

        $this->assertTrue($this->set->has('key1'));
    }

    public function testSetSerializesData()
    {
        $this->redis->expects($this->once())->method('hset')
            ->with($this->set, 'key1', serialize(array(1)));

        $this->set->set('key1', array(1));
    }

    public function testGetDeserializesValueBeforeReturning()
    {
        $this->redis->expects($this->at(0))->method('hget')
            ->with($this->set, 'key1')->will($this->returnValue(serialize(array('data'))));

        $this->redis->expects($this->at(1))->method('hget')
            ->with($this->set, 'key2')->will($this->returnValue(null));

        $this->assertEquals(array('data'), $this->set->get('key1'));
        $this->assertInternalType('null', $this->set->get('key2'));
    }

    public function testAllDeserializes()
    {
        $serialized = array(
            serialize(array('first')),
            serialize(array('second')),
        );

        $this->redis->expects($this->once())->method('hgetall')
            ->with($this->set)->will($this->returnValue($serialized));

        $this->assertEquals(array(array('first'), array('second')), $this->set->all());
    }
}
