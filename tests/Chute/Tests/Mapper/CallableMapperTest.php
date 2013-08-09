<?php

namespace Chute\Tests\Mapper;

use Chute\Mapper\CallableMapper;

class CallableMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testImplementsMapper()
    {
        $this->assertInstanceOf('Chute\Mapper', new CallableMapper('var_dump'));
    }

    public function testCallableIsCalledFromMap()
    {
        $mapper = new CallableMapper(function ($item) {
            return $item * 2;
        });

        $this->assertEquals(20, $mapper->map(10));
    }
}
