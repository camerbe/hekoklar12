<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RewriteAuthHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!$request->hasHeader('Authorization') && $request->hasHeader('X-Auth-Token')) {
            $request->headers->set('Authorization', 'Bearer ' . $request->header('X-Auth-Token'));
        }
        return $next($request);
    }
}
