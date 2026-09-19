<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // User logged in nahi hai
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Pehle login karein.');
        }

        $user = auth()->user();

        // User active nahi hai
        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Aapka account suspend kar diya gaya hai.');
        }

        // Role check karo
        if (empty($roles)) {
            abort(403, 'Role parameter required.');
        }

        if (!in_array($user->role?->name, $roles)) {
            abort(403, 'Aapko yahan access nahi hai.');
        }

        return $next($request);
    }
}