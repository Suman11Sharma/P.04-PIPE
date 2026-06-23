<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * Checks that the authenticated user has one of the specified roles.
     * Roles are passed as a comma-separated string in the middleware definition,
     * e.g., 'role:senior_researcher,junior_researcher'.
     *
     * Laravel's middleware parser passes the entire string after ':' as a
     * single argument, so we split by comma here.
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $allowedRoles = explode(',', $roles);

        foreach ($allowedRoles as $role) {
            if ($user->role_enum->value === trim($role)) {
                return $next($request);
            }
        }

        abort(403, 'You do not have the required permissions to access this area.');
    }
}
