<?php

namespace Chute\Tests;

use Chute\MapReduce;
use Chute\Tests\Fixtures;

class MapReduceTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mapper = new Fixtures\EvenMapper;
        $this->reducer = new Fixtures\AdditionReducer;
    }

    public function testImplementsMapperAndReducer()
    {
        $mapReduce = new MapReduce($this->mapper, $this->reducer);

        $this->assertInstanceOf('Chute\Mapper', $mapReduce);
        $this->assertInstanceOf('Chute\Reducer', $mapReduce);
    }

    public function testItMapReduces()
    {
        // It uses addition on all odd and even numbers.
        $mapReduce = new MapReduce($this->mapper, $this->reducer);
        $resultSet = $mapReduce->run(new \ArrayIterator(array(1, 2, 3, 4)));

        $this->assertInstanceOf('Chute\ResultSet\ArraySet', $resultSet);

        // We have two unique keys
        $this->assertCount(2, $resultSet);

        $this->assertEquals(4, $resultSet->get('not_even'));
        $this->assertEquals(6, $resultSet->get('even'));
    }

    public function testResultSetAreInterChangeable()
    {
        $resultSet = $this->getMock('Chute\ResultSet');
        $resultSet->expects($this->any())->method('keys')->will($this->returnValue(array()));

        $mapReduce = new MapReduce($this->mapper, $this->reducer);

        $this->assertSame($resultSet, $mapReduce->run(new \ArrayIterator(array()), $resultSet));
    }

    public function testMapToNullIgnoresValues()
    {
        $mapper = $this->getMock('Chute\Mapper');
        $mapper->expects($this->at(0))->method('map')->with($this->equalTo(1))->will($this->returnValue(array(
            'not_even', 1
        )));
        $mapper->expects($this->at(1))->method('map')->with($this->equalTo(2))->will($this->returnValue(null));

        $mapReduce = new MapReduce($mapper, $this->reducer);
        $resultSet = $mapReduce->run(new \ArrayIterator(array(1, 2))); // we just need two values.

        $this->assertEquals(array('not_even' => 1), $resultSet->all());
    }
}
