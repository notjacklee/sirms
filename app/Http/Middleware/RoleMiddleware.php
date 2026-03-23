<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware(['auth','role:admin'])
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // allow multiple roles separated by | e.g. role:admin|officer
        $roleList = explode('|', $roles);

        if (! in_array($user->role, $roleList)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
