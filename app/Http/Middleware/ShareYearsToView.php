<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Tahun;
use App\Models\Daerah;
use Illuminate\Support\Facades\View;

class ShareYearsToView
{
    public function handle(Request $request, Closure $next)
    {
        // $tahun = Tahun::all();
        // View::share(['tahun' => $tahun]);

        return $next($request);
    }
}
