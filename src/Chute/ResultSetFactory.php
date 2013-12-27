<?php

namespace Chute;

interface ResultSetFactory
{
    /**
     * @return ResultSet
     */
    public function create();
}
