<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePregistrationNotice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check for the initial ticket OR for validation errors being flashed
        if (session()->has('show_preregister_notice') || 
            session()->has('from_verification_form') ||
            (session()->has('errors') && session('errors')->any())) { // This is the new, smarter check
            return $next($request);
        }

        return redirect()->route('rapha.home');
    }
}
