<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use App\Models\Penawaran;
use PDF;
use Illuminate\Support\Facades\DB;

class PemenangController extends Controller
{
    public function cetakPemenang()
    {
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $daerahList = Daerah::withTrashed()
            ->where('main.id', $daftarIdFromSession)
            ->select(
                'kelurahans.kelurahan',
            )
            ->from('daerahs as main')
            ->leftJoin('tahuns', 'tahuns.id', 'main.thn_sts')
            ->leftJoin('kelurahans', 'kelurahans.id', 'main.id_kelurahan')
            ->first();

        $penawaranId = session('penawaran_id');
        $pemenangs = Penawaran::all();

        $pdf = PDF::loadview('pdf.pemenang.index', [
            'pemenangs' => $pemenangs,
            'daerahList' => $daerahList,
        ]);
        return $pdf->stream();
    }
}
