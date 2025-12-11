<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        // Must be authenticated admin
        $admin = auth()->guard('admins')->user();

        if (!$admin || $admin->user_type !== 'super_admin') {
            return abort(403, 'Unauthorized: Super Admins Only.');
        }

        return $next($request);
    }
}
