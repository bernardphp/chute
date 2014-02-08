Concepts
========

Mappers
-------

A ``Mapper`` maps or converts a value frome one data structure to another and decides how that should be grouped.
It does not matter what structure it is mapped into as long it is shared with its corresponding Reducer.

All Mappers must return an array looking like ``array($key, $structure)`` as the key is used to group its mapped
values into buckets. The contents of a bucket is given to a reduce one at the time until a single value is left.

Reducers
--------

A ``Reducer`` gets two values and has the responsibility to reduce them down into a single value. It is important
the reduced result has the exact same structure as the given arguments.

ResultSets
----------

When a MapReduce or Distributor returns the result, you will get a ``ResultSet``. By default this is just
a simple wrapper over an ``array``. But to limit the use of memory this could be implemented with Redis or Memcache
support.

In fact Chute does provide a ``RedisSet`` which uses a redis hash for the results. In order to hinder collisions if
multiple ResultSet's are used, ``RedisSet`` have a ``$key`` which is a Universally Unique Identifier (UUID) that is
used to isolate its result and being able to retrieve earlier results.

The ResultSet used is controlled by a ``ResultSetFactory`` implementation. This is the third optional argument to the
``MapReduce`` constructor. As it is optional it defaults to ``ArrayFactory`` which creates ``ArraySet`` instances.

.. code-block:: php

    <?php

    use Chute\ResultSet\RedisFactory;

    $mapReduce = new MapReduce($mapper, $reducer, new RedisFactory);

    // $resultSet will now be a `Chute\ResultSet\RedisSet` instance.
    $resultSet = $mapReduce->run(new ArrayIterator(array()));

Distributors
------------

Doing runs in parallel is good for performance, with forks and threads this can be done.
Chute provides a Distributor to do this.

.. code-block:: php

    <?php

    use Chute\Iterator\ChunkedIterator;
    use Chute\Distributor\SequentialDistributor;

    // $mapReduce contains the same mapper and reducer as the simplistic example further above.
    // it will split the ArrayIterator up into two chunks containing (1, 2) and (4, 5). When each
    // of the chunks have been completed it will merge the two resultsets together.
    $runner = new SequentialDistributor;
    $runner->run($mapReduce, new ChunkedIterator(new ArrayIterator([1, 2, 3, 4]), 2);

Of course the above example code is very simple as it just chunks up the iterator and runs them in a
sequential way.
