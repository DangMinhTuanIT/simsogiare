<?php

namespace App\Http\Middleware;

use Closure;

class ExpertAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->type != config('simsogiare.user_type.expert')) {
            return redirect()->route('access_denied');
        }
		
        return $next($request);
    }
}
