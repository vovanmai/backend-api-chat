<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocalizationMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request Request.
     * @param Closure $next    Next.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $default = config('app.locale');

        $translator = $request->header('Language', $request->get('language', $default));

        if (!in_array($translator, config('app.available_locales'))) {
            $translator = $default;
        }

        app('translator')->setLocale($translator);

        return $next($request);
    }
}
