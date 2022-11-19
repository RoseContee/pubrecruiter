<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if ($user['active'] != 1 || ($user['expires'] && $user['expires'] <= date('Y-m-d'))) {
            if ($request->ajax() || $request->expectsJson()) {
                return response([
                    'message' => 'Not authenticated',
                ], 401);
            }
        }
        return $next($request);
    }
}
