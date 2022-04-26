<?php

namespace App\Service\Request;

use App\Entity\LogRequest;
use App\Exceptions\ClientException\LimitException;
use App\Service\Request\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class issue :
 * 
 * Do NOT enforce the payments based on how many requests are logged in the database,
 * logging the requests is only for statistic purposes, since a user could make requests and wait until
 * the cache expieres or until redis starts to 'clean up' old cache.
 * 
 * It only makes sense to enforce a request limit and log statistics.
 */
class Limiter
{
    const TTL_FOREVER = 60 * 24 * 30; //30 days.

    /**
     * Private vars
     */
	private $counter;
	private $watcher;
	private $owner_id;
	private $limit;

    /**
     * Create a new request throttler.
     *
     * @param  \Illuminate\Cache\RateLimiter  $limiter
     * @return void
     */
    public function __construct(Request $request)
    {
    	$this->owner_id = $request->user()->owner_id;

        $this->counter = new Counter($this->getCounterTtl(), 'limiter.counter', $this->getKey());
        $this->watcher = new Counter(self::TTL_FOREVER, 'limiter.watcher', $this->getKey());
        $this->limit = new Counter(self::TTL_FOREVER, 'limiter.limit', $this->getKey());
    }

    /**
     * Add request to counter
     */
    public function add($amount = 1)
    {
    	if ($this->counter->isEmpty() && $this->watcher->hasPast())
    	{
    		$this->logRequests();
    		$this->limit->reset();
    		$this->watcher->reset();
    	}

    	$this->checkLimit();

    	$this->counter->add($amount);
    	$this->watcher->add($amount);
    }

    /**
     * Substract 
     * 
     * Don't apply the same to the watcher, because the watcher should return the amount of total requests
     * whereas the counter should just check if the request limit is exceeded.
     */
    public function substract($amount = 1)
    {
    	$this->counter->substract($amount);
    }

    /**
     * [checkLimit description]
     * 
     * @throws exception
     */
    private function checkLimit()
    {
        if ($this->hitLimit())
        {
            throw LimitException::aboveLimit($this->owner_id, $this->getCounterTtl(), $this->watcher->getCount());
        }
    } 

    /**
     * Check if the request limit was hit or not.
     * 
     * @return boolean true|false
     */
    private function hitLimit()
    {
        if ($this->counter->getCount() >= $this->getLimit())
        {
            return 1;
        }

        return 0;
    }

    /**
     * Get request limit
     * 
     * @return int
     */
    public function getLimit()
    { 
        if ($this->limit->isEmpty())
        {
            $this->refreshLimit();
        }

        return $this->limit->getCount();
    } 

    /**
     * Get current count
     * 
     * @return int
     */
    public function getCurrentCount()
    { 
        return $this->counter->getCount();
    }  

    /**
     * Refresh the request limit.
     * 
     * Get limit from owner, hit the db.
     * 
     * @return void
     */
    private function refreshLimit()
    {
        $limit = env('COUNTER_REQUESTS', 20);

        //$limit = DB::table('limits')->where('user_id', '=', $this->owner_id)->get(); //hit the database

    	$this->limit->setCount($limit);
    } 

    /**
     * Store request log in database.
     * 
     * @return void
     */
    private function logRequests()
    {
    	$logRequest = new LogRequest;

    	$logRequest->owner_id = $this->owner_id;
    	$logRequest->time_frame = $this->getCounterTtl();
    	$logRequest->amount = $this->watcher->getCount();
        $logRequest->hit_limit = $this->hitLimit();

    	return $logRequest->save();
    }

    /**
     * Counter ttl
     * 
     * Defaults to 8 hours. NOTE : changeable.
     * 
     * @return int
     */
    private function getCounterTtl()
    {
    	return env('COUNTER_TTL', 60 * 8);
    }

    /**
     * Watcher ttl
     * 
     * Defaults to double of getCounterTtl()
     * 
     * @return int
     */
    private function getWatcherTtl()
    {
        return self::TTL_FOREVER;

    	//return $this->getCounterTtl() * 2;
    }

    /**
     * Cache key
     * 
     * @return string hashed owner_id
     */
    private function getKey()
    {
    	return hash('md5', $this->owner_id);
    }
}