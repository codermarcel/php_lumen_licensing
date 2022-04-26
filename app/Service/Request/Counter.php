<?php

namespace App\Service\Request;

use Illuminate\Contracts\Cache\Repository as Cache;

class Counter
{
	private $ttl;
	private $tag;
	private $key;
	private $cache;

    /**
     * Create a new request throttler.
     *
     * @param  \Illuminate\Cache\RateLimiter  $limiter
     * @return void
     */
    public function __construct($ttl, $tag, $key, Cache $cache = null)
    {
        $this->ttl = $ttl;
        $this->tag = $tag;
        $this->key = $key;
        
        $this->cache = $cache ?: app(Cache::class);
    }

    /**
     * Get current count
     * 
     * @return int|null
     */
    public function getCount()
    {
    	return $this->cache->tags($this->getTag())->get($this->getKey());
    }

    /**
     * Set current count
     * 
     * @return void
     */
    public function setCount($count)
    {
    	return $this->cache->tags($this->getTag())->put($this->getKey(), $count, $this->getTtl());
    }

    /**
     * Check whether the counter is not empty
     * 
     * @return int|null
     */
    public function hasPast()
    {
    	return ! $this->isEmpty();
    }

    /**
     * Check whether counter is empty
     * 
     * @return int|null
     */
    public function isEmpty()
    {
    	return empty($this->getCount()) ? true : false;
    }

    /**
     * Add $amount to counter.
     */
    public function add($amount = 1)
    {
    	$this->ensureExists();

        $this->cache->tags($this->getTag())->increment($this->getKey(), $amount);
    }

    /**
     * Substract $amount from counter.
     */
    public function substract($amount = 1)
    {
    	$this->ensureExists();

        $this->cache->tags($this->getTag())->decrement($this->getKey(), $amount);
    }

    /**
     * Reset (forget) the counter.
     */
    public function reset()
    {
        $this->cache->tags($this->getTag())->forget($this->getKey());
    }

    /**
     * Ensure cache exists before working with it.
     * 
     * @return void
     */
    private function ensureExists()
    {
        if ( ! $this->cache->tags($this->getTag())->has($this->getKey()))
        {
        	$this->cache->tags($this->getTag())->put($this->getKey(), 0, $this->getTtl());
        }
    }

    /**
     * Get cache ttl
     */
    private function getTag()
    {
    	return $this->tag;
    } 

    /**
     * Get cache ttl
     */
    private function getTtl()
    {
    	return $this->ttl;
    } 

    /**
     * Get cache key
     */
    private function getKey()
    {
    	return $this->key;
    }
}