<?php

namespace Chute\Tests\Fixtures;

class EchoReturner
{
    public static function map($item)
    {
        return array('echo', $item);
    }

    public static function reduce($item, $previous)
    {
        return 'echo';
    }
}
