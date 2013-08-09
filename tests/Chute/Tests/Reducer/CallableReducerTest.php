<?php

namespace Chute\Tests\Reducer;

use Chute\Reducer\CallableReducer;

class CallableReducerTest extends \PHPUnit_Framework_TestCase
{
    public function testImplementsReducer()
    {
        $this->assertInstanceOf('Chute\Reducer', new CallableReducer('var_dump'));
    }

    public function testCallableIsCalledFromReduce()
    {
        $reducer = new CallableReducer(function ($item, $previous) {
            return $item + $previous;
        });

        $this->assertEquals(30, $reducer->reduce(10, 20));
    }
}
