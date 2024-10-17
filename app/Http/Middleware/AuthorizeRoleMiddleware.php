<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $rolesArray = explode(',', $role);
        if (!$request->user() || !$request->user()->hasAnyRole($rolesArray)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}