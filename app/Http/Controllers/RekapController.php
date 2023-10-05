<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use App\Models\Penawaran;
use PDF;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    public function cetakRekap()
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

        $rekaps = Penawaran::all();

        $pdf = PDF::loadview('pdf.rekap-sts.index', [
            'rekaps' => $rekaps,
            'daerahList' => $daerahList,
        ]);
        return $pdf->stream();
    }
}
