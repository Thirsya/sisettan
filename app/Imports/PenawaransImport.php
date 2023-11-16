<?php

namespace App\Imports;

use App\Models\Daftar;
use App\Models\Penawaran;
use App\Models\Tkd;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class PenawaransImport implements ToCollection, WithHeadingRow, WithUpserts
{
    public function collection(Collection $rows)
    {
        $penawaransData = [];

        foreach ($rows as $row) {
            $daftar = Daftar::where('id_daftar', $row['id_daftar'])->first();
            $tkd = Tkd::where('id_tkd', $row['id_tkd'])->first();

            if (!$daftar || !$tkd) {
                continue;
            }

            $luasTkd = $tkd->luas;
            $totalLuasPenawaran = Penawaran::where('idfk_daftar', $daftar->id)->sum('total_luas');
            $totalLuas = $luasTkd + $totalLuasPenawaran;

            $penawaransData[] = [
                'id_penawaran' => $row['id_penawaran'],
                'idfk_daftar' => $daftar->id,
                'id_daftar' => $daftar->id_daftar,
                'idfk_tkd' => $tkd->id,
                'id_tkd' => $tkd->id_tkd,
                'nilai_penawaran' => $row['nilai_penawaran'],
                'keterangan' => $row['keterangan'],
                'total_luas' => $totalLuas,
                'gugur' => $row['gugur'],
            ];
        }

        Penawaran::upsert($penawaransData, 'id_penawaran', ['total_luas']);

        DB::table('penawarans')
            ->join(
                DB::raw('(SELECT idfk_daftar, SUM(total_luas) as total_luas FROM penawarans GROUP BY idfk_daftar)
                 as penawaran_totals'),
                'penawarans.idfk_daftar',
                '=',
                'penawaran_totals.idfk_daftar'
            )
            ->select('penawarans.id', 'penawaran_totals.total_luas')
            ->update(['penawarans.total_luas' => DB::raw('penawaran_totals.total_luas')]);

        return redirect()->route('penawaran.index')->with('success', 'Data Penawaran Berhasil Diimport');
    }



    public function uniqueBy()
    {
        return 'id_penawaran';
    }
}
