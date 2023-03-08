<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param mixed ...$roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roleSlugs)
    {
        if (!auth()->check()) {
            abort(403, 'Permission Denied');
        }

        $isValid = false;

        foreach (auth()->user()->roles as $role) {
            if (in_array($role->slug, $roleSlugs)) {
                $isValid = true;
            }
        }

        if ($isValid) {
            return $next($request);
        }

        abort(403, 'Permission Denied');
    }

}
