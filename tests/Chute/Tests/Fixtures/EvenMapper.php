<?php

namespace Chute\Tests\Fixtures;

class EvenMapper implements \Chute\Mapper
{
    public function map($item)
    {
        $key = $item % 2 === 0 ? 'even' : 'not_even';

        return array($key, $item);
    }
}
