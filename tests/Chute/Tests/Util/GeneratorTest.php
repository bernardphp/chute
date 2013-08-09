<?php

namespace Chute\Tests\Util;

use Chute\Util\Generator;

class GeneratorTests extends \PHPUnit_Framework_TestCase
{
    public function testUuidIsValid()
    {
        // regex is from http://stackoverflow.com/a/12808694/1508691
        $regex = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

        $this->assertEquals(1, preg_match($regex, Generator::generateUuid()));
    }
}
