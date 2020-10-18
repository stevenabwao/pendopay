<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
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

        if (auth()->user() === null) {
            return response("Unauthenticated", 401);
        }

        // superadmin has access to everything
        if(isSuperAdmin()) {
            return $next($request);
        }

        // check the actions in routes
        $actions = $request->route()->getAction('roles');

        // check if actions has a role key
        $roles = isset($actions['roles']) ? $actions['roles'] : null;

        // if user has the role or route has no specified role, proceed
        if ($request->user()->hasAnyRole($roles) || !$roles) {
            return $next($request);
        }

        // if we reach here, user is not allowed here
        return response("Unauthenticated", 401);

    }

}
