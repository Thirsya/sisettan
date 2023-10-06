<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreGugurRequest;
use App\Http\Requests\UpdateGugurRequest;
use App\Models\Penawaran;
use App\Models\Daerah;
use PDF;
use Illuminate\Support\Facades\DB;

class GugurController extends Controller
{
    public function cetakGugur()
    {
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $daerahList = Daerah::withTrashed()
            ->where('main.id', $daftarIdFromSession)
            ->select(
                'main.periode',
                'tahuns.tahun',
                'kelurahans.kelurahan',
                'main.noba',
            )
            ->from('daerahs as main')
            ->leftJoin('tahuns', 'tahuns.id', 'main.thn_sts')
            ->leftJoin('kelurahans', 'kelurahans.id', 'main.id_kelurahan')
            ->first();

        $penawaranId = session('penawaran_id');
        $gugurs = Penawaran::all();

        $pdf = PDF::loadview('pdf.gugur.index', [
            'gugurs' => $gugurs,
            'daerahList' => $daerahList,
        ]);
        return $pdf->stream();
    }
}
