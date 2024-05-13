<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use App\Models\Daftar;
use App\Models\Penawaran;
use App\Models\Tahun;
use PDF;
use Illuminate\Support\Facades\DB;

class PemenangController extends Controller
{
    public function cetakPemenang()
    {
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::where('id', $selectedTahunId)->value('tahun');


        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $daerahList = Daerah::withTrashed()
            ->where('main.id_kelurahan', $daftarIdFromSession)
            ->whereYear('tanggal_lelang', $tahunSelected)
            ->select(
                'kelurahans.kelurahan',
            )
            ->from('daerahs as main')
            ->leftJoin('tahuns', 'tahuns.id', 'main.thn_sts')
            ->leftJoin('kelurahans', 'kelurahans.id', 'main.id_kelurahan')
            ->first();

        $penawaranId = session('penawaran_id');

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
            'daftar2.nama as nama2',
            'daftar3.nama as nama3',
            'daftar4.nama as nama4',
            'daftar5.nama as nama5',
            'daftars.tgl_perjanjian',
            'tkds.bukti',
            'tkds.letak',
            'tkds.bidang',
            'tkds.harga_dasar',
            'tkds.luas',
            'tkds.keterangan',
            'penawarans.id',
            'penawarans.total_luas',
            'penawarans.idfk_tkd',
            'penawarans.idfk_daftar',
            'penawarans.nilai_penawaran',
            DB::raw('
                    (SELECT nilai_penawaran
                     FROM penawarans AS subquery
                     WHERE subquery.idfk_tkd = penawarans.idfk_tkd
                     AND subquery.nilai_penawaran IS NOT NULL
                     ORDER BY subquery.nilai_penawaran DESC
                     LIMIT 1 OFFSET 1) AS nilai_penawaran2
                '),
            DB::raw('
    (SELECT nilai_penawaran
     FROM penawarans AS subquery
     WHERE subquery.idfk_tkd = penawarans.idfk_tkd
     AND subquery.nilai_penawaran IS NOT NULL
     ORDER BY subquery.nilai_penawaran DESC
     LIMIT 1 OFFSET 2) AS nilai_penawaran3
'),

            DB::raw('
    (SELECT nilai_penawaran
     FROM penawarans AS subquery
     WHERE subquery.idfk_tkd = penawarans.idfk_tkd
     AND subquery.nilai_penawaran IS NOT NULL
     ORDER BY subquery.nilai_penawaran DESC
     LIMIT 1 OFFSET 3) AS nilai_penawaran4
'),

            DB::raw('
    (SELECT nilai_penawaran
     FROM penawarans AS subquery
     WHERE subquery.idfk_tkd = penawarans.idfk_tkd
     AND subquery.nilai_penawaran IS NOT NULL
     ORDER BY subquery.nilai_penawaran DESC
     LIMIT 1 OFFSET 4) AS nilai_penawaran5
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
                 LIMIT 1) AS idfk_daftar2
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
                     LIMIT 1 OFFSET 2)
                 LIMIT 1) AS idfk_daftar3
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
                     LIMIT 1 OFFSET 3)
                 LIMIT 1) AS idfk_daftar4
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
                     LIMIT 1 OFFSET 4)
                 LIMIT 1) AS idfk_daftar5
            '),
        )
            ->joinSub($sub, 'subquery', function ($join) {
                $join->on('penawarans.idfk_tkd', '=', 'subquery.idfk_tkd')
                    ->on('penawarans.nilai_penawaran', '=', 'subquery.max_penawaran');
            })
            ->leftJoin('tkds', 'tkds.id', '=', 'penawarans.idfk_tkd')
            ->leftJoin('daftars', 'daftars.id', '=', 'penawarans.idfk_daftar')
            ->leftJoin('daftars as daftar2', 'daftar2.id', '=',  DB::raw('
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
            ->leftJoin('daftars as daftar3', function ($join) {
                $join->on('daftar3.id', '=', DB::raw('
                (SELECT idfk_daftar
                 FROM penawarans AS subquery
                 WHERE subquery.idfk_tkd = tkds.id
                 AND subquery.nilai_penawaran =
                    (SELECT nilai_penawaran
                     FROM penawarans
                     WHERE idfk_tkd = tkds.id
                     AND nilai_penawaran IS NOT NULL
                     ORDER BY nilai_penawaran DESC
                     LIMIT 1 OFFSET 2)
                 LIMIT 1)
            '));
            })
            ->leftJoin('daftars as daftar4', function ($join) {
                $join->on('daftar4.id', '=', DB::raw('
                (SELECT idfk_daftar
                 FROM penawarans AS subquery
                 WHERE subquery.idfk_tkd = tkds.id
                 AND subquery.nilai_penawaran =
                    (SELECT nilai_penawaran
                     FROM penawarans
                     WHERE idfk_tkd = tkds.id
                     AND nilai_penawaran IS NOT NULL
                     ORDER BY nilai_penawaran DESC
                     LIMIT 1 OFFSET 3)
                 LIMIT 1)
            '));
            })
            ->leftJoin('daftars as daftar5', function ($join) {
                $join->on('daftar5.id', '=', DB::raw('
                (SELECT idfk_daftar
                 FROM penawarans AS subquery
                 WHERE subquery.idfk_tkd = tkds.id
                 AND subquery.nilai_penawaran =
                    (SELECT nilai_penawaran
                     FROM penawarans
                     WHERE idfk_tkd = tkds.id
                     AND nilai_penawaran IS NOT NULL
                     ORDER BY nilai_penawaran DESC
                     LIMIT 1 OFFSET 4)
                 LIMIT 1)
            '));
            })

            ->where('daftars.id_kelurahan', $kelurahanIdFromDaerah)
            ->orderBy('tkds.bukti', 'DESC')
            ->get();
        $winners = Penawaran::select('idfk_tkd', 'idfk_daftar', 'nilai_penawaran')
            ->whereNull('deleted_at')
            ->where('gugur', '=', false)
            ->get()
            ->transform(function ($item) {
                $item->nilai_penawaran = intval($item->nilai_penawaran);
                return $item;
            })
            ->sortByDesc('nilai_penawaran')
            ->groupBy('idfk_tkd')
            ->map(function ($group) {
                return $group->take(5);
            });

        $winnerDetails = Daftar::whereIn('id', $winners->flatten()->pluck('idfk_daftar'))->get();
        $winnersWithDetails = $winners->map(function ($group) use ($winnerDetails) {
            return $group->map(function ($item) use ($winnerDetails) {
                $detail = $winnerDetails->firstWhere('id', $item->idfk_daftar);
                $item->nama = $detail ? $detail->nama : null;
                return $item;
            });
        });

        $pdf = PDF::loadview('pdf.pemenang.index', [
            'penawaran' => $penawaran,
            'daerahList' => $daerahList,
            'winnersWithDetails' => $winnersWithDetails,
        ])->setPaper('a4', 'landscape');
        return $pdf->stream('PEMENANG 1-5.pdf');
    }
}
