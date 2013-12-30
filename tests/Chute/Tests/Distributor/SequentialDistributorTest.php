<?php

namespace Chute\Tests\Distributor;

use Chute\MapReduce;
use Chute\Distributor\SequentialDistributor;
use Chute\Tests\Fixtures;
use Chute\Iterator\ChunkedIterator;
use ArrayIterator;

class SequentialDistributorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mapReduce = new MapReduce(new Fixtures\EvenMapper, new Fixtures\AdditionReducer);
        $this->runner = new SequentialDistributor();
    }

    public function testItUsesResultSetFactory()
    {
        $resultSet = $this->getMock('Chute\ResultSet');

        $factory = $this->getMock('Chute\ResultSetFactory');
        $factory->expects($this->exactly(2))->method('create')->will($this->returnValue($resultSet));

        $iterator = new ChunkedIterator(new ArrayIterator(range(1, 4)), 2);
        $distributor = new SequentialDistributor($factory);

        $distributor->run($this->mapReduce, $iterator);
    }

    public function testRun()
    {
        $iterator = new ArrayIterator(range(1, 4));

        $resultSet = $this->runner->run($this->mapReduce, new ChunkedIterator($iterator, 2));

        $this->assertEquals(4, $resultSet->get('not_even'));
        $this->assertEquals(6, $resultSet->get('even'));
    }

    public function testItReturnsResultSetWhenNoIterationsAreDone()
    {
        $iterator = new ArrayIterator(array());

        $resultSet = $this->runner->run($this->mapReduce, $iterator);

        $this->assertInstanceOf('Chute\ResultSet\ArraySet', $resultSet);
        $this->assertEquals(array(), $resultSet->all());
    }
}
