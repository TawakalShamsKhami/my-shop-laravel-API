<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = $request->attributes->get('jwt_user');

        // if (! $user || ! $user->hasPermission($permission)) {
        //     return response()->json(['message' => 'Access denied'], 403);
        // }

        return $next($request);
    }
}
