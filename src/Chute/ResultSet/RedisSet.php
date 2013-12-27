<?php

namespace Chute\ResultSet;

use Chute\Util\Generator;
use Redis;

/**
 * Redis ResultSet that uses hashes to temporarily save
 * values.
 */
class RedisSet extends AbstractSet
{
    protected $redis;

    /**
     * @param Redis       $redis
     * @param string|null $key
     */
    public function __construct(Redis $redis, $key = null)
    {
        $this->redis = $redis;
        $this->key = chute_generate_uuid();
    }

    /**
     * {@inheritDoc}
     */
    public function get($group)
    {
        if ($data = $this->redis->hget($this->key, $group)) {
            return json_decode($data, true);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->keys());
    }

    /**
     * {@inheritDoc}
     */
    public function set($group, $value)
    {
        $this->redis->hset($this->key, $group, json_encode($value));
    }

    /**
     * {@inheritDoc}
     */
    public function has($group)
    {
        return $this->redis->hexists($this->key, $group);
    }

    /**
     * {@inheritDoc}
     */
    public function keys()
    {
        return $this->redis->hkeys($this->key);
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        return $this->redis->hgetall($this->key);
    }
}
