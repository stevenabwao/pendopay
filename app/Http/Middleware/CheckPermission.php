<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$permissions)
    {

        if (auth()->user() === null) {
            return response("Unauthorized", 403);
        }

        // superadmin has access to everything
        if(isSuperAdmin()) {
            return $next($request);
        }

        // check permission

        // if we reach here, user is not allowed here
        return response("Unauthorized", 403);

    }
}
