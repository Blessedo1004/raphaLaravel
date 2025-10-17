<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserEdit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check for the initial ticket OR for validation errors being flashed
        if (session()->has('edit_form') || 
            (session()->has('errors') && session('errors')->any())) {
            return $next($request);
        }

          return redirect()->route('profile');
        
    }

    

    
}
