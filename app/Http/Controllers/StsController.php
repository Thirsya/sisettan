<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use App\Models\Daftar;
use App\Models\Penawaran;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class StsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::where('id', $selectedTahunId)->value('tahun');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id_kelurahan', $daftarIdFromSession)
            ->whereYear('tanggal_lelang', $tahunSelected)
            ->pluck('id_kelurahan')->first();

        $sub = Penawaran::select('idfk_tkd', DB::raw('MAX(nilai_penawaran) as max_penawaran'))
            ->whereNull('deleted_at')
            ->where('gugur', '=', false)
            ->groupBy('idfk_tkd');

        $penawaran = Penawaran::select(
            'daftars.no_urut',
            'daftars.nama',
            'daftars.tgl_perjanjian',
            'tkds.bukti',
            'tkds.bidang',
            'tkds.luas',
            'penawarans.id',
            'penawarans.nilai_penawaran',
            'penawarans.idfk_tkd',
            'penawarans.idfk_daftar'
        )
            ->joinSub($sub, 'subquery', function ($join) {
                $join->on('penawarans.idfk_tkd', '=', 'subquery.idfk_tkd')
                    ->on('penawarans.nilai_penawaran', '=', 'subquery.max_penawaran');
            })
            ->leftJoin('tkds', 'tkds.id', '=', 'penawarans.idfk_tkd')
            ->leftJoin('daftars', 'daftars.id', '=', 'penawarans.idfk_daftar')
            ->where('daftars.id_kelurahan', $kelurahanIdFromDaerah)
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
                     WHERE subquery.idfk_tkd = penawarans.idfk_tkd
                     AND subquery.nilai_penawaran IS NOT NULL
                     ORDER BY subquery.nilai_penawaran DESC
                     LIMIT 1 OFFSET 1) AS nilai_penawaran
                '),
            DB::raw('
                (SELECT idfk_daftar
                 FROM penawarans AS subquery
                 WHERE subquery.idfk_tkd = tkds.id
                 AND subquery.nilai_penawaran =
                    (SELECT nilai_penawaran
                     FROM penawarans
                     WHERE idfk_tkd = tkds.id
                     AND nilai_penawaran IS NOT NULL
                     ORDER BY nilai_penawaran DESC
                     LIMIT 1 OFFSET 1)
                 LIMIT 1) AS idfk_daftar
            ')
        )
            ->leftJoin('tkds', 'tkds.id', '=', 'penawarans.idfk_tkd')
            ->leftJoin('daftars', 'daftars.id', '=',  DB::raw('
            (SELECT idfk_daftar
             FROM penawarans AS subquery
             WHERE subquery.idfk_tkd = tkds.id
             AND subquery.nilai_penawaran =
                (SELECT nilai_penawaran
                 FROM penawarans
                 WHERE idfk_tkd = tkds.id
                 AND nilai_penawaran IS NOT NULL
                 ORDER BY nilai_penawaran DESC
                 LIMIT 1 OFFSET 1)
             LIMIT 1)
        '))
            ->where('daftars.id_kelurahan', $kelurahanIdFromDaerah)
            ->whereNull('penawarans.deleted_at')
            ->where('penawarans.gugur', '=', false)
            ->havingRaw('nilai_penawaran IS NOT NULL')
            ->groupBy('penawarans.idfk_tkd')
            ->orderBy('tkds.bukti', 'DESC')
            ->get();


        return view('lelang.penawaran.sts', compact('penawaran', 'penawaran2'));
    }

    public function gugur(Request $request, $id)
    {
        $penawaran = Penawaran::find($id);
        if (!$penawaran) {
            return response()->json(['message' => 'Penawaran not found!'], 404);
        }
        $penawaran->gugur = true;
        $penawaran->save();

        return response()->json(['message' => 'Successfully updated!']);
    }

    public function updateDate(Penawaran $penawaran, Request $request)
    {
        if (!$penawaran) {
            return response()->json(['message' => 'Penawaran not found!'], 404);
        }

        $daftar = Daftar::find($penawaran->idfk_daftar);

        if (!$daftar) {
            return response()->json(['message' => 'Daftar not found!'], 404);
        }

        $daftar->tgl_perjanjian = $request->tgl_perjanjian;
        $daftar->save();

        return response()->json(['message' => 'Date updated successfully']);
    }

    public function printSTS($id)
    {
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $daerahList = Daerah::withTrashed()
            ->where('main.id', $daftarIdFromSession)
            ->select(
                'main.periode',
                'tahuns.tahun',
                'kelurahans.kelurahan',
                'main.noba',
                'tkds.bukti',
                'tkds.bidang',
                'tkds.letak',
                'tkds.luas',
                'daftars.nama',
            )
            ->from('daerahs as main')
            ->leftJoin('tahuns', 'tahuns.id', 'main.thn_sts')
            ->leftJoin('kelurahans', 'kelurahans.id', 'main.id_kelurahan')
            ->leftJoin('tkds', 'tkds.id_kelurahan', 'kelurahans.id')
            ->leftJoin('daftars', 'daftars.id_kelurahan', 'kelurahans.id')
            ->first();

        $penawaranId = session('penawaran_id');
        $idDaftar = Penawaran::select('penawarans.idfk_daftar')
            ->where('penawarans.id', $id)
            ->first();

        $totalNilaiPenawaran = Penawaran::where('penawarans.idfk_daftar', $idDaftar->idfk_daftar)
            ->sum('penawarans.nilai_penawaran');


        $pdf = PDF::loadview('lelang.penawaran.cetak-sts', [
            'totalNilaiPenawaran' => $totalNilaiPenawaran,
            'daerahList' => $daerahList,
        ]);
        return $pdf->stream('sts-' . $id . '.pdf');
    }

    public function cetakPernyataan()
    {
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $daerahList = Daerah::withTrashed()
            ->where('main.id', $daftarIdFromSession)
            ->select(
                'main.periode',
                'tahuns.tahun',
                'kelurahans.kelurahan',
                'main.noba',
                'tkds.bukti',
                'tkds.bidang',
                'tkds.letak',
                'tkds.luas',
                'daftars.nama',
                'daftars.alamat',
            )
            ->from('daerahs as main')
            ->leftJoin('tahuns', 'tahuns.id', 'main.thn_sts')
            ->leftJoin('kelurahans', 'kelurahans.id', 'main.id_kelurahan')
            ->leftJoin('tkds', 'tkds.id_kelurahan', 'kelurahans.id')
            ->leftJoin('daftars', 'daftars.id_kelurahan', 'kelurahans.id')
            ->first();

        $penawaranId = session('penawaran_id');
        return view('lelang.penawaran.pernyataan');
    }

    public function cetakPerjanjian()
    {
        return view('lelang.penawaran.perjanjian');
    }
}
