<?php

namespace spec\Chute;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MapReduceSpec extends ObjectBehavior
{
    /**
     * @param Chute\Mapper $mapper
     * @param Chute\Reducer $reducer
     */
    function let($mapper, $reducer)
    {
        $this->beConstructedWith($mapper, $reducer);
    }

    function its_a_mapper($mapper)
    {
        $this->shouldHaveType('Chute\Mapper');

        $mapper->map(1)->shouldBeCalled();

        $this->map(1);
    }

    function its_a_reducer($reducer)
    {
        $this->shouldHaveType('Chute\Reducer');

        $reducer->reduce(1, 1)->shouldBeCalled();

        $this->reduce(1, 1);
    }

    function it_map_reduces($mapper, $reducer)
    {
        $iterator = new \ArrayIterator(array(1, 2, 3, 4));

        $mapper->map(1)->willReturn(array('odd', 1));
        $mapper->map(2)->willReturn(array('even', 2));
        $mapper->map(3)->willReturn(array('odd', 3));
        $mapper->map(4)->willReturn(array('even', 4));

        $reducer->reduce(3, 1)->willReturn(4);
        $reducer->reduce(4, 2)->willReturn(6);

        $resultSet = $this->run($iterator);

        $resultSet->all()->shouldReturn(array(
            'odd' => 4,
            'even' => 6,
        ));
    }

    /**
     * @param Chute\ResultSetFactory $factory
     * @param Chute\ResultSet $resultSet
     * @param Iterator $iterator
     */
    function it_uses_factory_to_create_result_sets($factory, $resultSet, $iterator)
    {
        $factory->create()->willReturn($resultSet);

        $this->run($iterator, $factory)->shouldReturn($resultSet);
    }
}
