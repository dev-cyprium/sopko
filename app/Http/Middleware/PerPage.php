<?php

namespace App\Http\Middleware;

use Closure;
use App\Facades\Sopko;

class PerPage
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
        $val = $request->query('per_page');
        Sopko::remember('per_page', $val ? $val:15 );
        return $next($request);
    }
}
