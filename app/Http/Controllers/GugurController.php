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
    public function index()
    {
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id', $daftarIdFromSession)->pluck('id_kelurahan')->first();

        $penawaran = Penawaran::select(
            'daftars.no_urut',
            'daftars.nama',
            'daftars.tgl_perjanjian',
            'tkds.bukti',
            'tkds.bidang',
            'tkds.luas',
            'penawarans.id',
            DB::raw('MAX(penawarans.nilai_penawaran) as nilai_penawaran'),
            'penawarans.idfk_tkd'
        )
            ->leftJoin('tkds', 'tkds.id', '=', 'penawarans.idfk_tkd')
            ->leftJoin('daftars', 'daftars.id', '=', 'penawarans.idfk_daftar')
            ->where('daftars.id_kelurahan', $kelurahanIdFromDaerah)
            ->whereNull('penawarans.deleted_at')
            ->where('penawarans.gugur', '=', false)
            ->groupBy('penawarans.idfk_tkd')
            ->orderBy('tkds.bukti', 'DESC')
            ->get();

        $penawaran2 = Penawaran::select(
            'daftars.no_urut',
            'daftars.nama',
            'daftars.tgl_perjanjian',
            'tkds.bukti',
            'tkds.bidang',
            'tkds.luas',
            'penawarans.id',
            DB::raw('
                    (SELECT nilai_penawaran
                    FROM penawarans AS subquery
                    WHERE subquery.idfk_tkd = tkds.id
                    AND subquery.nilai_penawaran IS NOT NULL
                    ORDER BY subquery.nilai_penawaran DESC
                    LIMIT 1 OFFSET 1) AS nilai_penawaran
                '),
            'penawarans.idfk_tkd'
        )
            ->leftJoin('tkds', 'tkds.id', '=', 'penawarans.idfk_tkd')
            ->leftJoin('daftars', 'daftars.id', '=', 'penawarans.idfk_daftar')
            ->where('daftars.id_kelurahan', $kelurahanIdFromDaerah)
            ->whereNull('penawarans.deleted_at')
            ->where('penawarans.gugur', '=', false)
            ->havingRaw('nilai_penawaran IS NOT NULL')
            ->groupBy('penawarans.idfk_tkd')
            ->orderBy('tkds.bukti', 'DESC')
            ->get();

        return view('lelang.penawaran.sts', compact('penawaran', 'penawaran2'));
    }

    public function cetakGugur()
    {
        $gugurs = Penawaran::all();

        $pdf = PDF::loadview('pdf.gugur.index', ['gugurs'=>$gugurs]);
        return $pdf->stream('Gugur');
    }
}
