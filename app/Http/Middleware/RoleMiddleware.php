<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role, $idParam)
    {
        $userId = $request->route($idParam);
        $user = User::find($userId);

        if (!$user || $user->rol->name !== $role) {
            return response('This user does\'nt have a '. $role ." rol", 403);
        }

        return $next($request);
    }
}
