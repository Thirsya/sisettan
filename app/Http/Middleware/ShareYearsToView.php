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
        $tahun = Tahun::all();
        $daerah = Daerah::select(
            'daerahs.id',
            'daerahs.tanggal_lelang',
            'daerahs.id_kelurahan',
            'daerahs.id_kecamatan',
            'kelurahans.kelurahan',
            'kecamatans.kecamatan as kecamatan',
        )
            ->leftJoin('kecamatans', 'daerahs.id_kecamatan', '=', 'kecamatans.id')
            ->leftJoin('kelurahans', 'daerahs.id_kelurahan', '=', 'kelurahans.id')
            ->get();

        View::share(['tahun' => $tahun, 'daerah' => $daerah]);

        return $next($request);
    }
}
