<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->isTeacher() || Auth::user()->isAdmin())) {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'No tienes permisos de docente para acceder a esta sección.');
    }
}
