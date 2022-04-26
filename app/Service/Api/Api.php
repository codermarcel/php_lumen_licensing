<?php

namespace App\Service\Api;

use App\Service\Request\Limiter;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class Api extends ApiResponse
{
    /**
     * Named constructors
     */
    public static function ok($request = null)
    {
        $api = new static($request);

        return $api->build();
    }

    public static function error(Exception $e, Request $request = null)
    {
        list($code, $message) = (new ExceptionConverter)->convertException($e);

        $api = new static($request);
        $api->setCode($code);
        $api->setMessage($message);
        
        return $api->build();
    }
    
    public static function fromSearch($result, $request, $name = 'result')
    {
        $api = new static($request);

        $api->setRequestLimits(true);

        if ($result instanceof LengthAwarePaginator)
        {
            return $api->fromAdvanced($result, $name);
        }

        return $api->fromSimple($result, $name);
    }

    /**
     * Search stuff
     */
    public function fromAdvanced(LengthAwarePaginator $result, $name)
    {
        $data = $result->toArray();

        $this->set('total', $data['total']);
        $this->set('count', $data['per_page']);
        $this->set('from', $data['from']);
        $this->set('to', $data['to']);
        $this->set('next_page_url', $data['next_page_url']);
        $this->set('prev_page_url', $data['prev_page_url']);
        $this->set($name, $data['data']);

        return $this->build();
    }

    public function fromSimple($result, $name)
    {
        list($total, $result) = $result;

        $this->set('total', $total);
        $this->set('count', count($result));
        $this->set($name, $result);

        return $this->build();
    }

    /**
     * Setter
     */
    public function setToken($input)
    {
        return $this->set('token', $input);
    }

    public function setMessage($message = null)
    {
        if ( ! empty($message))
        {
            $this->set('message', $message);
        }

        return $this;
    }

    public function cachable($cachable = true)
    {
        return $this->setHeader('Cachable', $cachable);
    }

    /**
     * Request Limits
     */
    public function setRequestLimits($asHeader = false)
    {
        if ($this->isAuthenticated())
        {
            $limiter = new Limiter($this->request);

            $limit   = $limiter->getLimit();
            $current = $limiter->getCurrentCount();
            $remaining = $limiter->getLimit() - $limiter->getCurrentCount();



            // $data = [
            //     'limit'     => $limit,
            //     'current'   => $current,
            //     'remaining' => $remaining,
            // ];

            // $this->set('request', $data, $asHeader);

            $this->set('requests_limit', $limit, $asHeader);
            $this->set('requests_current', $current, $asHeader);
            $this->set('requests_remaining', $remaining, $asHeader);
        }

        return $this;
    }

    private function isAuthenticated()
    {
        try {
            $user = $this->request->user();
            return true;
        } catch (\Exception $e) {
        }

        return false;
    }
}