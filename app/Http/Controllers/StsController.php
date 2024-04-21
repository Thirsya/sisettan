<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use App\Models\Daftar;
use App\Models\Penawaran;
use App\Models\Sts;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
            'penawarans.idfk_daftar',
            'sts.surat_tanda_setor',
            'sts.surat_pernyataan',
            'sts.surat_perjanjian',
            'sts.berita_acara',
        )
            ->joinSub($sub, 'subquery', function ($join) {
                $join->on('penawarans.idfk_tkd', '=', 'subquery.idfk_tkd')
                    ->on('penawarans.nilai_penawaran', '=', 'subquery.max_penawaran');
            })
            ->leftJoin('tkds', 'tkds.id', '=', 'penawarans.idfk_tkd')
            ->leftJoin('sts', 'sts.id_penawaran', '=', 'penawarans.id')
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

    public function cetakPernyataan($id)
    {
        $idDaftar = Penawaran::select('penawarans.idfk_daftar')
            ->where('penawarans.id', $id)
            ->first();
        $daerahList = Daftar::select(
            'daftars.id',
            'daftars.nama',
            'daftars.alamat',
            'daftars.id_kelurahan',
            'kelurahans.kelurahan',
            'daerahs.periode',
            DB::raw('YEAR(daerahs.tanggal_lelang) as tahun_lelang')
        )

            ->leftJoin('daerahs', 'daerahs.id_kelurahan', 'daftars.id_kelurahan')
            ->leftJoin('kelurahans', 'kelurahans.id', 'daftars.id_kelurahan')
            ->where('daftars.id', $idDaftar->idfk_daftar)
            ->first();
        return view('lelang.penawaran.pernyataan')->with([
            'daerahList' => $daerahList,
        ]);
    }

    public function cetakPerjanjian($id)
    {
        $idDaftar = Penawaran::select(
            'penawarans.idfk_daftar',
            'penawarans.nilai_penawaran',
            'penawarans.total_luas',
        )
            ->where('penawarans.id', $id)
            ->first();
        $sub = Penawaran::select('idfk_tkd', DB::raw('MAX(nilai_penawaran) as max_penawaran'))
            ->whereNull('deleted_at')
            ->where('gugur', '=', false)
            ->groupBy('idfk_tkd');
        $listPenawaran = DB::table('penawarans')
            ->select(
                'penawarans.id',
                'penawarans.id_daftar',
                'penawarans.idfk_daftar',
                'penawarans.id_tkd',
                'penawarans.idfk_tkd',
                'penawarans.nilai_penawaran',
                'penawarans.keterangan',
                'penawarans.total_luas',
                'daftars.id_daftar',
                'daftars.no_urut',
                'daftars.nama',
                'daftars.alamat',
                'daftars.no_kk',
                'daftars.no_wp',
                'daftars.tgl_perjanjian',
                'tkds.id_tkd',
                'tkds.id_kelurahan',
                'kelurahans.kelurahan',
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
            ->leftJoin('kelurahans', 'kelurahans.id', 'tkds.id_kelurahan')
            ->where('daftars.id', $idDaftar->idfk_daftar)
            ->whereNull('penawarans.deleted_at')
            ->orderBy('tkds.bukti', 'DESC')
            ->get();
        // dd($listPenawaran);

        $daerahList = Daftar::select(
            'daftars.id',
            'daftars.nama',
            'daftars.alamat',
            'daftars.id_kelurahan',
            'kelurahans.id_kecamatan',
            'kecamatans.kecamatan',
            'kelurahans.kelurahan',
            'daerahs.periode',
            'daerahs.tanggal_lelang',
            DB::raw('YEAR(daerahs.tanggal_lelang) as tahun_lelang'),
            DB::raw('MONTH(daerahs.tanggal_lelang) as bulan_lelang')
        )
            ->leftJoin('daerahs', 'daerahs.id_kelurahan', 'daftars.id_kelurahan')
            ->leftJoin('kelurahans', 'kelurahans.id', 'daftars.id_kelurahan')
            ->leftJoin('kecamatans', 'kecamatans.id', 'kelurahans.id_kecamatan')
            ->where('daftars.id', $idDaftar->idfk_daftar)
            ->first();
        return view('lelang.penawaran.perjanjian')->with([
            'daerahList' => $daerahList,
            'idDaftar' => $idDaftar,
            'listPenawaran' => $listPenawaran,
        ]);
    }

    public function upload(Request $request)
    {
        $validatedData = $request->validate([
            'fileSts' => 'nullable|mimes:pdf|max:5000',
            'filePernyataan' => 'nullable|mimes:pdf|max:5000',
            'filePerjanjian' => 'nullable|mimes:pdf|max:5000',
            'fileBa' => 'nullable|mimes:pdf|max:5000',
            'id_penawaran' => 'required|integer',
        ]);

        // Cek apakah Sts dengan id_penawaran yang diberikan sudah ada
        $sts = Sts::where('id_penawaran', $request->id_penawaran)->first();

        // Jika tidak, buat yang baru
        if (!$sts) {
            $sts = new Sts();
            $sts->id_penawaran = $request->id_penawaran;
        }

        // Generate random name for the files
        $randomName = Str::random(10);

        // Mendapatkan ekstensi file dan menyimpan file di storage
        if ($request->hasFile('fileSts')) {
            $extensionSts = $request->file('fileSts')->getClientOriginalExtension();
            $request->file('fileSts')->storeAs('public/sts', $randomName . '.' . $extensionSts);
            $sts->surat_tanda_setor = $randomName . '.' . $extensionSts;
        }

        if ($request->hasFile('filePernyataan')) {
            $extensionPernyataan = $request->file('filePernyataan')->getClientOriginalExtension();
            $request->file('filePernyataan')->storeAs('public/sts', $randomName . '.' . $extensionPernyataan);
            $sts->surat_pernyataan = $randomName . '.' . $extensionPernyataan;
        }

        if ($request->hasFile('filePerjanjian')) {
            $extensionPerjanjian = $request->file('filePerjanjian')->getClientOriginalExtension();
            $request->file('filePerjanjian')->storeAs('public/sts', $randomName . '.' . $extensionPerjanjian);
            $sts->surat_perjanjian = $randomName . '.' . $extensionPerjanjian;
        }

        if ($request->hasFile('fileBa')) {
            $extensionBa = $request->file('fileBa')->getClientOriginalExtension();
            $request->file('fileBa')->storeAs('public/sts', $randomName . '.' . $extensionBa);
            $sts->berita_acara = $randomName . '.' . $extensionBa;
        }

        $sts->save();

        return response()->json(['message' => 'Files uploaded successfully']);
    }
}
