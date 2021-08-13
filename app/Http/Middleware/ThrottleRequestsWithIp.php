<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests as Middleware;

class ThrottleRequestsWithIp extends Middleware
{
    protected $exclusion = [
        "3.18.12.63",
        "3.130.192.231",
        "13.235.14.237",
        "13.235.122.149",
        "35.154.171.200",
        "52.15.183.38",
        "54.187.174.169",
        "54.187.205.235",
        "54.187.216.72",
        "54.241.31.99",
        "54.241.31.102",
        "54.241.34.107",
        "120.0.0.1",
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     */
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        if (in_array($request->ip(), $this->exclusion))
            return $next($request);

        return parent::handle($request, $next, $maxAttempts, $decayMinutes, $prefix);
    }
}
