<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AuthKey;
use Illuminate\Support\Facades\Auth;

class ApiAuthMiddleware
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
        $key = $request->header('Authorization');
        $dbKey = AuthKey::where('hash', $key)->first();        

        if(!$dbKey) {
            return response()->json(['message' => 'This action is not permited. Pleaase add the Authorization header and it\'s key'], 403);
        }

        return $next($request);
    }
}
