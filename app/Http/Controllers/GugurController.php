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
        $kelurahanIdFromDaerah = Daerah::where('id', $daftarIdFromSession)->pluck('id_kelurahan')->first();
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

        $sub = Penawaran::select('idfk_tkd', DB::raw('MAX(nilai_penawaran) as max_penawaran'))
            ->whereNull('deleted_at')
            ->where('gugur', '=', true)
            ->groupBy('idfk_tkd');

        $penawarans = DB::table('penawarans')
            ->select(
                'penawarans.id',
                'penawarans.id_daftar',
                'penawarans.idfk_daftar',
                'penawarans.id_tkd',
                'penawarans.idfk_tkd',
                'penawarans.nilai_penawaran',
                'penawarans.keterangan',
                'penawarans.total_luas',
                'penawarans.keterangan',
                'daftars.id_daftar',
                'daftars.no_urut',
                'daftars.nama',
                'daftars.alamat',
                'daftars.no_kk',
                'daftars.no_wp',
                'daftars.tgl_perjanjian',
                'tkds.id_tkd',
                'tkds.id_kelurahan',
                'tkds.bidang',
                'tkds.letak',
                'tkds.bukti',
                'tkds.harga_dasar',
                'tkds.luas',
                'tkds.keterangan',
                'tkds.nop',
            )
            ->joinSub($sub, 'subquery', function ($join) {
                $join->on('penawarans.idfk_tkd', '=', 'subquery.idfk_tkd')
                    ->on('penawarans.nilai_penawaran', '=', 'subquery.max_penawaran');
            })
            ->leftJoin('tkds', 'penawarans.idfk_tkd', '=', 'tkds.id')
            ->leftJoin('daftars', 'penawarans.idfk_daftar', '=', 'daftars.id')
            ->where('daftars.id_kelurahan', $kelurahanIdFromDaerah)
            ->whereNull('penawarans.deleted_at')
            ->orderBy('tkds.bukti', 'DESC')
            ->get();

        $pdf = PDF::loadview('pdf.gugur.index', [
            'penawarans' => $penawarans,
            'daerahList' => $daerahList,
        ]);
        return $pdf->stream();
    }
}
