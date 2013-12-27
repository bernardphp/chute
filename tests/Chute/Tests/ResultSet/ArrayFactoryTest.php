<?php

namespace Chute\Tests\ResultSet;

use Chute\ResultSet\ArrayFactory;

class ArrayFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testItCreatesArraySet()
    {
        $factory = new ArrayFactory;

        $this->assertInstanceOf('Chute\ResultSet\ArraySet', $factory->create());
    }
}
