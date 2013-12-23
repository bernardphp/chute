<?php

namespace Chute\Tests\Util;

use Chute\Util\ChunkedIterator;
use ArrayIterator;

class ChunkedIteratorTest extends \PHPUnit_Framework_TestCase
{
    public function testItChunksInternalIterator()
    {
        $iterator = new ChunkedIterator(new ArrayIterator(array(1, 2, 3, 4, 5, 6)), 3);

        $iterator->next();
        $this->assertEquals(new ArrayIterator(array(1, 2, 3)), $iterator->current());


        $iterator->next();
        $this->assertEquals(new ArrayIterator(array(4, 5, 6)), $iterator->current());
    }

    public function testItRewinds()
    {
        $iterator = new ChunkedIterator(new ArrayIterator(array(1, 2, 3, 4, 5, 6)), 3);
        $iterator->next();
        $iterator->next();

        $this->assertEquals(new ArrayIterator(array(4, 5, 6)), $iterator->current());

        $iterator->rewind();
        $this->assertEquals(new ArrayIterator(array(1, 2, 3)), $iterator->current());
    }
}
