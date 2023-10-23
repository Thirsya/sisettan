<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckKelurahanSession
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->hasRole('super-admin')) {
            return $next($request);
        }

        if (session()->has('selected_kelurahan_id') && !empty(session('selected_kelurahan_id'))) {
            return $next($request);
        }

        return redirect()->route('dashboard');
    }
}
