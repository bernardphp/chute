<?php

namespace spec\Chute\ResultSet;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArraySetSpec extends ObjectBehavior
{
    /**
     * @param Chute\ResultSet $resultSet
     * @param Chute\Reducer   $reducer
     */
    function it_merge_with_another_result_set($resultSet, $reducer)
    {
        $this->set('odd', 4);
        $this->set('even', 6);

        $resultSet->keys()->willReturn(array('even'));
        $resultSet->get('even')->willReturn(10);

        $reducer->reduce(10, 6)->willReturn(16);

        $this->merge($reducer, $resultSet);

        $this->all()->shouldReturn(array(
            'odd' => 4,
            'even' => 16,
        ));
    }

    function it_returns_null_when_getting_key_that_does_not_exists()
    {
        $this->get('does not exists')->shouldReturn(null);
    }

    /**
     * @param Chute\ResultSet $resultSet
     * @param Chute\Reducer   $reducer
     */
    function it_adds_new_keys_when_merging($resultSet, $reducer)
    {
        $resultSet->get('new_key')->willReturn(10);
        $resultSet->keys()->willReturn(array('new_key'));

        $this->merge($reducer, $resultSet);

        $this->get('new_key')->shouldReturn(10);
    }

    function it_acts_as_array_object()
    {
        $this->set('odd', 1);
        $this->set('even', 10);

        $this->get('odd')->shouldReturn(1);
        $this->get('even')->shouldReturn(10);

        $this->has('odd')->shouldReturn(true);
        $this->has('xyz')->shouldReturn(false);

        $this->keys()->shouldReturn(array('odd', 'even'));

        $this->count()->shouldReturn(2);
    }

    function it_allows_getting_all_values_as_array()
    {
        $this->set('foo', 1);
        $this->set('bar', 2);

        $this->all()->shouldReturn(array(
            'foo' => 1,
            'bar' => 2,
        ));
    }
}
