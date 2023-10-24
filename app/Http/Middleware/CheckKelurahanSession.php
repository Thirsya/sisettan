<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelurahan;
use App\Models\Daerah;
use App\Models\Tahun;

class CheckKelurahanSession
{
    public function handle(Request $request, Closure $next)
    {
        // if (Auth::user()->hasRole('super-admin')) {
        //     return $next($request);
        // }

        $selectedKelurahanId = session('selected_kelurahan_id');
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::where('id', $selectedTahunId)->value('tahun');

        if ($selectedKelurahanId) {
            $hasDaerahForGivenYear = Daerah::where('id_kelurahan', $selectedKelurahanId)
                ->whereYear('tanggal_lelang', $tahunSelected)
                ->exists();
            if ($hasDaerahForGivenYear) {
                return $next($request);
            }
        }

        return redirect()->route('dashboard');
    }
}
