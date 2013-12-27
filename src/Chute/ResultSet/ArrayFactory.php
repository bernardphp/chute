<?php

namespace Chute\ResultSet;

class ArrayFactory implements \Chute\ResultSetFactory
{
    public function create()
    {
        return new ArraySet;
    }
}
