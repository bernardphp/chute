<?php

namespace Chute;

/**
 * @package Chute
 */
interface Mapper
{
    /**
     * Takes an $item and transform it into another structure that can
     * be reduced. It return an array with two keys, the 0 index is a $key
     * that values are grouped with. The second is the transformed structure.
     *
     * @param  mixed $item
     * @return array
     */
    public function map($item);
}
