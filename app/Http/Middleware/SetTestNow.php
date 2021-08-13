<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class SetTestNow
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (env('APP_ENV') != 'production' && env('FAKE_CURRENT_TIME')) {
            Carbon::setTestNow(env('FAKE_CURRENT_TIME'));
        }
        return $next($request);
    }
}
