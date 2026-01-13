<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!in_array($request->session()->get('userType'), array('superadmin'))) {
            echo '<div style="font-size: 18px; color: #a72323; background: #ffc1c1; padding: 15px; text-align: center;">Access denied</div>';
            return exit();
        }

        return $next($request);
    }
}
