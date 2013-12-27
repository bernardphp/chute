Chute
=====

Chute is a MapReduce Framework for PHP. It enables doing map reduce over iterators (``Traversable``) and pushes
the decision for Hadoop out into the future.

Getting Started
---------------

Everything starts with a ``MapReduce``. The mapreducer binds a ``Mapper`` and ``Reducer`` together. It takes a ``Mapper``
and a ``Reducer`` as constructor arguments.

A ``Mapper`` takes an item of data and returns it as an array looking like ``array($key, $values)``.
The key is used to group the different mapped values.

A ``Reducer`` gets two mapped values and it's the job of the ``Reducer`` to merge them  together and return a new value.
It is important that the returned value have the same structure as the given values.

Putting it all together with a ``CallableMapper`` and ``CallableReducer`` we get the following:

.. code-block:: php

    <?php

    use Chute\MapReduce;
    use Chute\Mapper\CallableMapper;
    use Chute\Reducer\CallableReducer;

    $mapper = new CallableMapper(function ($item) {
      $isEven = $item % 2 === 0;

      return [$isEven ? 'even' : 'not_even', $item];
    });

    $reducer = new CallableReducer(function ($item, $previous) {
      return $item + $previous;
    });

    $mapReduce = new MapReduce($mapper, $reducer);
    $resultSet = $mapReduce->run(new ArrayIterator([1, 2, 3, 4]));

The ``$resultSet`` will now contain two keys. A ``even`` and a ``not_even``. Because the Reducer just added the values
the result for ``even`` will be ``6`` which is 2 + 4 and the ``not_even`` key will be 4 which is 1 + 3.

This is just a simple example of what kind of calculations that can be done.

ResultSets
~~~~~~~~~~

When a MapReduce or Distributor returns the result, you will get a ``ResultSet``. By default this is just
a simple wrapper over an ``array``. But to limit the use of memory this could be implemented with Redis or Memcache
support.

In fact Chute does provide a ``RedisSet`` which uses a redis hash for the results. In order to hinder collisions if
multiple ResultSet's are used, every ResultSet have a ``$key`` (if they extend ``AbstractSet``) which is a
Universally Unique Identifier (UUID).

The ResultSet used is controlled by a ``ResultSetFactory`` implementation. This is the third optional argument to the
``MapReduce`` constructor. As it is optional it defaults to ``ArrayFactory`` which creates ``ArraySet`` instances.

.. code-block:: php

    <?php

    use Chute\ResultSet\RedisFactory;

    $mapReduce = new MapReduce($mapper, $reducer, new RedisFactory);

    // $resultSet will now be a `Chute\ResultSet\RedisSet` instance.
    $resultSet = $mapReduce->run(new ArrayIterator(array()));

Distributors
~~~~~~~~~~~~

Doing runs in parallel is good for performance, with forks and threads this can be done.
Chute provides a Distributor to do this.

.. code-block:: php

    <?php

    use Chute\Util\ChunkedIterator;
    use Chute\Distributor\SequentialDistributor;

    // $mapReduce contains the same mapper and reducer as the simplistic example further above.
    // it will split the ArrayIterator up into two chunks containing (1, 2) and (4, 5). When each
    // of the chunks have been completed it will merge the two resultsets together.
    $runner = new SequentialDistributor;
    $runner->run($mapReduce, new ChunkedIterator(new ArrayIterator([1, 2, 3, 4]), 2);

Of course the above example code is very simple as it just chunks up the iterator and runs them in a
sequential way.

Frequently Asked Questions
--------------------------

Collection of Tips, Tricks and other question often asked when using this library.

Can values be ignored?
~~~~~~~~~~~~~~~~~~~~~~

Yes. When a ``Mapper::map()`` returns ``null``. The value will not be reduced but ignored and will not be
added to the result set.

Is it a good idea? Probably not, but i needed it.

Credits
-------

Chute is developed mainly be these wonderful people. Or they have made
a significant contribution.

 * `@Fant <https://github.com/Fant>`__
 * `@igorw <https://github.com/igorw>`__
 * `@henrikbjorn <https://github.com/henrikbjorn>`__
