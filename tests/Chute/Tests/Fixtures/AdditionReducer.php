<?php

namespace Chute\Tests\Fixtures;

class AdditionReducer implements \Chute\Reducer
{
    public function reduce($item, $previous)
    {
        return $item + $previous;
    }
}
