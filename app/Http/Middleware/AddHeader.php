<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($token = $request->token) {
            $request->headers->set('Authorization', "Bearer {$token}");
        }
        return $next($request);
    }
}
