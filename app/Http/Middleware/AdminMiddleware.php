<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is admin (email is admin@example.com for this example)
        // In a real application, you would use a role/permission system
        if ($request->user() && $request->user()->email === 'admin@example.com') {
            return $next($request);
        }

        abort(403, 'Unauthorized access');
    }
}
