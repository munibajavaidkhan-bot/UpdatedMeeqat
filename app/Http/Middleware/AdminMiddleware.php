<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Please login first.');
        }

        $user = auth()->user();

        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Your account is blocked.');
        }

        // Only admin and editor can access admin panel
        if (!$user->isAdminOrEditor()) {
            abort(403, 'Admin panel is only for admins.');
        }

        return $next($request);
    }
}