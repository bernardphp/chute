<?php

namespace Chute\ResultSet;

use Redis;

class RedisFactory implements \Chute\ResultSetFactory
{
    protected $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function create()
    {
        return new RedisSet($this->redis);
    }
}
