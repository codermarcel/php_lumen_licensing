<?php

namespace App\Http\Middleware;

use App\Service\Request\Limiter;
use Closure;

class RequestLimiter
{
    protected $limiter;

    public function __construct(Limiter $limiter)
    {
        $this->limiter = $limiter;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $maxAttempts
     * @param  int  $decayMinutes
     * @return mixed
     */
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1)
    {
        $this->limiter->add(1);

        return $next($request);
    }
}