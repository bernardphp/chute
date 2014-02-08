Chute
=====

Chute is a MapReduce Framework for PHP. It enables doing map reduce over iterators (``Traversable``) and pushes
the decision for Hadoop out into the future.

Installing
----------

Chute is installed with `Composer <http://getcomposer.org>`_.

.. code-block:: bash

    $ composer require bernard/chute:~1.0

Simple Example
--------------

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

Contributors
------------

Chute is developed mainly be these wonderful people. Or they have made
a significant contribution.

* `@Fant <https://github.com/Fant>`__
* `@igorw <https://github.com/igorw>`__
* `@henrikbjorn <https://github.com/henrikbjorn>`__
* `All Contributors <https://github.com/bernardphp/juno/contributors>`_
