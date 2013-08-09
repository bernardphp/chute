<?php

namespace Chute\Tests\Distributor;

use Chute\MapReduce;
use Chute\Distributor\SequentialDistributor;
use Chute\Tests\Fixtures;
use Chute\Util\ChunkedIterator;

class SequentialDistributorTest extends \PHPUnit_Framework_TestCase
{
    public function testRun()
    {
        $mapReduce = new MapReduce(new Fixtures\EvenMapper, new Fixtures\AdditionReducer);
        $iterator = new \ArrayIterator(range(1, 4));

        $runner = new SequentialDistributor();

        $resultSet = $runner->run($mapReduce, new ChunkedIterator($iterator, 2));

        $this->assertEquals(4, $resultSet->get('not_even'));
        $this->assertEquals(6, $resultSet->get('even'));
    }
}
