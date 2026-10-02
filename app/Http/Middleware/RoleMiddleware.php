<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Usage in routes: ->middleware('role:admin,instructor')
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user() || !in_array($request->user()->role->name, $roles)) {
            abort(403, 'You do not have access to this area of the platform.');
        }

        return $next($request);
    }
}
