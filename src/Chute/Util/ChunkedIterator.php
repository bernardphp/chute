<?php

/*
 * Copyright (c) 2011 Michael Dowling, https://github.com/mtdowling <mtdowling@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Chute\Util;

use ArrayIterator;
use Traversable;

/**
 * Pulls out chunks from an inner iterator and yields the chunks as instances
 * of ArrayIterator
 */
class ChunkedIterator extends \IteratorIterator
{
    protected $chunkSize;
    protected $chunk;

    /**
     * @param Traversable $iterator
     * @param integer     $chunkSize
     */
    public function __construct(Traversable $iterator, $chunkSize)
    {
        parent::__construct($iterator);

        $this->chunkSize = $chunkSize;
    }

    public function rewind()
    {
        $this->getInnerIterator()->rewind();
        $this->next();
    }

    public function next()
    {
        $items = array();
        $inner = $this->getInnerIterator();

        for ($i = 0; $i < $this->chunkSize; $i++) {
            if (!$inner->valid()) {
                break;
            }

            $items[] = $inner->current();
            $inner->next();
        }

        $this->chunk = new ArrayIterator($items);
    }

    public function current()
    {
        return $this->chunk;
    }

    public function valid()
    {
        return count($this->chunk);
    }
}
