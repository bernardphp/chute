<?php

namespace Chute\Tests\ResultTest;

use Chute\Tests\Fixtures;
use Chute\ResultSet\ArraySet;

class ArraySetTest extends \PHPUnit_Framework_TestCase
{
    public function testMerge()
    {
        $a = new ArraySet;
        $a->set('a', 1);
        $a->set('b', 2);

        $b = new ArraySet;
        $b->set('a', 4);
        $b->set('c', 3);

        $a->merge(new Fixtures\AdditionReducer, $b);

        $this->assertEquals(5, $a->get('a'));
        $this->assertEquals(2, $a->get('b'));
        $this->assertEquals(3, $a->get('c'));
    }
}
