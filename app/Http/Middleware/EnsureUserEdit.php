<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


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
        $user = Auth::user();
        if($user->role==="regular"){
          return redirect()->route('dashboard');
        }
        
        return redirect()->route('admin-dashboard');
        
    }

    

    
}
