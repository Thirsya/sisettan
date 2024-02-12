<?php

namespace App\Http\Controllers;

use App\Exports\PenawaransExport;
use App\Http\Requests\ImportPenawaranRequest;
use App\Models\Penawaran;
use App\Http\Requests\StorePenawaranRequest;
use App\Http\Requests\UpdatePenawaranRequest;
use App\Imports\PenawaransImport;
use App\Models\Daerah;
use App\Models\Daftar;
use App\Models\Kecamatan;
use App\Models\Tahun;
use App\Models\Tkd;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PenawaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:daftar.index')->only('index');
        $this->middleware('permission:daftar.create')->only('create', 'store');
        $this->middleware('permission:daftar.edit')->only('edit', 'update');
        $this->middleware('permission:daftar.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $tkds = Tkd::all();
        $harga_dasar = $request->input('harga_dasar');
        // $tahunId = session('tahun_id');
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::where('id', $selectedTahunId)->value('tahun');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id_kelurahan', $daftarIdFromSession)
            ->whereYear('tanggal_lelang', $tahunSelected)
            ->pluck('id_kelurahan')->first();

        $daftarList = Daftar::select(
            'daftars.id',
            'daftars.id_kelurahan',
            'daftars.no_urut',
            'daftars.nama',
            'daftars.alamat',
            'daftars.no_kk',
            'daftars.no_wp',
            'daftars.tgl_perjanjian',
            'kelurahans.kelurahan'
        )
            ->leftJoin('kelurahans', 'daftars.id_kelurahan', '=', 'kelurahans.id')
            ->where('daftars.id_kelurahan', $kelurahanIdFromDaerah)
            ->whereNull('daftars.deleted_at')
            ->orderByRaw("CAST(daftars.no_urut AS SIGNED) ASC")
            ->get();

        $maxPenawaranByTkd = DB::table('penawarans')
            ->select('idfk_tkd', DB::raw('MAX(nilai_penawaran) as max_penawaran'))
            ->groupBy('idfk_tkd');
        $daftarWithMaxPenawaran = DB::table('penawarans')
            ->joinSub($maxPenawaranByTkd, 'sub_max', function ($join) {
                $join->on('penawarans.idfk_tkd', '=', 'sub_max.idfk_tkd')
                    ->whereColumn('penawarans.nilai_penawaran', 'sub_max.max_penawaran');
            })
            ->select('penawarans.idfk_daftar')
            ->distinct();
        $penawarans = DB::table('penawarans')
            ->select(
                'penawarans.id',
                'penawarans.id_daftar',
                'penawarans.idfk_daftar',
                'penawarans.id_tkd',
                'penawarans.idfk_tkd',
                'penawarans.nilai_penawaran',
                'penawarans.keterangan',
                'penawarans.gugur',
                DB::raw('CASE
                WHEN penawarans.idfk_daftar IN (' . $daftarWithMaxPenawaran->toSql() . ') THEN penawarans.total_luas
                ELSE 0
            END as total_luas'),
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
            ->mergeBindings($daftarWithMaxPenawaran)
            ->leftJoin('tkds', 'penawarans.idfk_tkd', '=', 'tkds.id')
            ->leftJoin('daftars', 'penawarans.idfk_daftar', '=', 'daftars.id')
            ->when($request->input('bukti'), function ($query, $bukti) {
                return $query->where('bukti', 'like', '%' . $bukti . '%');
            })
            ->when($request->input('bukti'), function ($query, $bukti) {
                return $query->whereIn('daerah.jenis_barang_id', $bukti);
            })
            // ->whereYear('daftars.tgl_perjanjian', $tahunId)
            ->where('daftars.id_kelurahan', $kelurahanIdFromDaerah)
            ->whereNull('penawarans.deleted_at')
            ->orderBy('daftars.nama', 'ASC')
            ->paginate(10);
        $tkdSelected = $request->input('bukti');
        return view('lelang.penawaran.index')->with([
            'penawarans' => $penawarans,
            'tkds' => $tkds,
            'tkdSelected' => $tkdSelected,
            'harga_dasar' => $harga_dasar,
            'daftarList' => $daftarList,
        ]);
    }

    public function handleForm(Request $request)
    {
        $request->validate([
            'penawaran' => 'required',
        ]);
        session(['penawaran_id' => $request->penawaran]);
        return redirect()->route('penawaran.create');
    }

    public function create(Request $request)
    {
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::where('id', $selectedTahunId)->value('tahun');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id_kelurahan', $daftarIdFromSession)
            ->whereYear('tanggal_lelang', $tahunSelected)
            ->pluck('id_kelurahan')->first();

        $penawaranId = session('penawaran_id');
        $tkds = DB::table('tkds')
            ->select(
                'tkds.id',
                'tkds.id_kelurahan',
                'tkds.bidang',
                'tkds.letak',
                'tkds.bukti',
                'tkds.harga_dasar',
                'tkds.luas',
                'tkds.keterangan',
                'tkds.nop',
                DB::raw('COALESCE((SELECT nilai_penawaran
                        FROM penawarans
                        WHERE idfk_tkd = tkds.id
                        ORDER BY nilai_penawaran DESC
                        LIMIT 1 OFFSET 1), null) AS nilai_penawaran')
            )
            ->where('id_kelurahan', $kelurahanIdFromDaerah)
            ->whereNull('tkds.deleted_at')
            ->when($request->input('tkd'), function ($query, $tkd) {
                return $query->where('tkds.bukti', 'like', '%' . $tkd . '%');
            })
            ->get();

        $daftars = Daftar::where('id', $penawaranId)->first();
        return view('lelang.penawaran.create')->with([
            'tkds' => $tkds,
            'daftars' => $daftars,
        ]);
    }

    public function getTkd(Request $request)
    {
        $tkd = Tkd::where('id', $request->id)->first();

        return response()->json([
            'luas' => $tkd->luas,
            'harga_dasar' => $tkd->harga_dasar
        ]);
    }

    public function store(StorePenawaranRequest $request)
    {
        if ($request->ajax()) {
            try {
                $tkdId = $request->input('idfk_tkd');
                $value = $request->input('nilai_penawaran');

                if (is_null($value)) {
                    return response()->json(['success' => false, 'message' => 'Nilai penawaran is missing']);
                }

                $daftar = Daftar::find($request->input('idfk_daftar'));
                if (!$daftar) {
                    return response()->json(['success' => false, 'message' => 'Daftar not found']);
                }

                $idDaftar = $daftar->id_daftar;
                $idKelurahan = $daftar->id_kelurahan;
                $idTkd = Tkd::where('id', $tkdId)->pluck('id_tkd')->first();

                $idPenawaran = $idKelurahan . "X" . $idDaftar . $idTkd;

                $penawaran = Penawaran::create([
                    'id_penawaran' => $idPenawaran,
                    'total_luas' => 0,
                    'idfk_daftar' => $request->input('idfk_daftar'),
                    'id_daftar' => $idDaftar,
                    'idfk_tkd' => $tkdId,
                    'id_tkd' => $idTkd,
                    'nilai_penawaran' => $value,
                    'keterangan' => '',
                ]);

                $totalLuasTkd = Tkd::where('id', $penawaran->idfk_tkd)->sum('luas');
                $totalLuasPenawaran = Penawaran::where('idfk_daftar', $penawaran->idfk_daftar)->value('total_luas');
                $newTotalLuas = $totalLuasTkd + $totalLuasPenawaran;

                Penawaran::where('idfk_daftar', $penawaran->idfk_daftar)->update(['total_luas' => $newTotalLuas]);

                return response()->json(['success' => true, 'message' => 'Data saved successfully']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
            }
        } else {
            //
        }
    }

    public function show(StorePenawaranRequest $request)
    {
        Penawaran::create([
            'id_daftar' => $request->id_daftar,
            'id_tkd' => $request->id_tkd,
            'nilai_penawaran' => $request->nilai_penawaran,
            'keterangan' => $request->keterangan,
        ]);
        return redirect()->route('penawaran.index')->with('success', 'Tambah Data Penawaran Sukses');
    }

    public function edit(Penawaran $penawaran)
    {
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::where('id', $selectedTahunId)->value('tahun');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id_kelurahan', $daftarIdFromSession)
            ->whereYear('tanggal_lelang', $tahunSelected)
            ->pluck('id_kelurahan')->first();

        $tkds = Tkd::where('id_kelurahan', $kelurahanIdFromDaerah)->get();
        $daftars = Daftar::where('id_kelurahan', $kelurahanIdFromDaerah)->get();
        $idfkTkd = $penawaran->idfk_tkd;
        $tkdList = Tkd::where('id', $idfkTkd)->first();
        return view('lelang.penawaran.edit',)
            ->with([
                'tkds' => $tkds,
                'daftars' => $daftars,
                'penawaran' => $penawaran,
                'tkdList' => $tkdList,
            ]);
    }

    public function update(UpdatePenawaranRequest $request, Penawaran $penawaran)
    {
        $penawaran->update($request->validated());
        return redirect()->route('penawaran.index')->with('success', 'Penawaran updated successfully.');
    }

    public function destroy(Penawaran $penawaran)
    {
        $penawaran->delete();

        $totalLuasTkd = Tkd::where('id', $penawaran->idfk_tkd)->pluck('luas')->first();
        $totalLuasPenawaran = Penawaran::where('idfk_daftar', $penawaran->idfk_daftar)->pluck('total_luas')->first();

        if ($totalLuasTkd !== null && $totalLuasPenawaran !== null) {
            $newTotalLuas = $totalLuasPenawaran - $totalLuasTkd;

            Penawaran::where('idfk_daftar', $penawaran->idfk_daftar)->update(['total_luas' => $newTotalLuas]);
        }

        return redirect()->route('penawaran.index')->with('success', 'Penawaran deleted successfully.');
    }


    public function import(ImportPenawaranRequest $request)
    {
        Excel::import(new PenawaransImport, $request->file('import-file')->store('import-files'));
        return redirect()->route('penawaran.index')->with('success', 'Tambahkan Data Penawaran Sukses diimport');
    }

    public function export()
    {
        return Excel::download(new PenawaransExport, 'Penawaran.xlsx');
    }

    public function deleteAll()
    {
        Penawaran::truncate(); // Menghapus semua baris pada tabel

        return redirect()->back()->with('success', 'Semua data berhasil dihapus.');
    }

    public function downloadTemplate()
    {
        $templatePath = public_path('Excel/templates/penawaran_template.xlsx');
        if (!file_exists($templatePath)) {
            return redirect()->route('penawaran.index')->with('error', 'Template file not found.');
        }

        return response()->download($templatePath, 'penawaran_template.xlsx');
    }

    // public function cetakLuas()
    // {
    //     $luass = Penawaran::all();

    //     $pdf = PDF::loadview('lelang.penawaran.luas', ['luass' => $luass]);
    //     return $pdf->stream();
    // }

    public function cetakTidakLaku()
    {
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::where('id', $selectedTahunId)->value('tahun');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id_kelurahan', $daftarIdFromSession)
            ->whereYear('tanggal_lelang', $tahunSelected)
            ->pluck('id_kelurahan')->first();

        $daerahList = Daerah::withTrashed()
            ->where('main.id', $daftarIdFromSession)
            ->select(
                'kelurahans.kelurahan',
            )
            ->from('daerahs as main')
            ->leftJoin('tahuns', 'tahuns.id', 'main.thn_sts')
            ->leftJoin('kelurahans', 'kelurahans.id', 'main.id_kelurahan')
            ->first();

        $penawarans = DB::table('tkds')
            ->leftJoin('penawarans', 'tkds.id', '=', 'penawarans.idfk_tkd')
            ->leftJoin('kelurahans', 'tkds.id_kelurahan', '=', 'kelurahans.id')
            ->select(
                'tkds.id',
                'tkds.bukti',
                'tkds.letak',
                'tkds.bidang',
                'tkds.harga_dasar',
                'tkds.luas'
            )
            ->whereNull('penawarans.idfk_tkd')
            ->whereNull('penawarans.deleted_at')
            ->where('tkds.id_kelurahan', $kelurahanIdFromDaerah)
            ->get();


        $pdf = PDF::loadview('lelang.penawaran.tidak-laku', [
            'penawarans' => $penawarans,
            'daerahList' => $daerahList,
        ]);
        return $pdf->stream();
    }

    public function cetakBA()
    {
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::where('id', $selectedTahunId)->value('tahun');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id_kelurahan', $daftarIdFromSession)
            ->whereYear('tanggal_lelang', $tahunSelected)
            ->pluck('id_kelurahan')->first();

        $daerahList = Daerah::withTrashed()
            ->where('main.id', $daftarIdFromSession)
            ->select(
                'main.periode',
                'kelurahans.kelurahan',
                'main.noba',
            )
            ->from('daerahs as main')
            ->leftJoin('tahuns', 'tahuns.id', 'main.thn_sts')
            ->leftJoin('kelurahans', 'kelurahans.id', 'main.id_kelurahan')
            ->first();

        $sub = Penawaran::select('idfk_tkd', DB::raw('MAX(nilai_penawaran) as max_penawaran'))
            ->whereNull('deleted_at')
            ->where('gugur', '=', false)
            ->groupBy('idfk_tkd');

        $penawaran = Penawaran::select(
            'daftars.no_urut',
            'daftars.nama',
            'daftar2.nama as nama2',
            'daftars.tgl_perjanjian',
            'tkds.bukti',
            'tkds.letak',
            'tkds.bidang',
            'tkds.harga_dasar',
            'tkds.luas',
            'penawarans.id',
            'penawarans.nilai_penawaran',
            'penawarans.idfk_tkd',
            'penawarans.idfk_daftar',
            DB::raw('
                    (SELECT nilai_penawaran
                     FROM penawarans AS subquery
                     WHERE subquery.idfk_tkd = penawarans.idfk_tkd
                     AND subquery.nilai_penawaran IS NOT NULL
                     ORDER BY subquery.nilai_penawaran DESC
                     LIMIT 1 OFFSET 1) AS nilai_penawaran2
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
            ')
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
            ->where('daftars.id_kelurahan', $kelurahanIdFromDaerah)
            ->orderBy('tkds.bukti', 'DESC')
            ->get();

        $pdf = PDF::loadView('lelang.penawaran.cetak-ba', [
            'penawarans' => $penawaran,
            'daerahList' => $daerahList,
        ]);

        return $pdf->stream('cetak-ba.pdf');
    }

    public function cetakSekota()
    {
        $cetakSekota = Tkd::select(
            'kelurahans.kelurahan',
            DB::raw('COUNT(DISTINCT tkds.bidang) as total_bidang'),
            DB::raw('SUM(tkds.luas) as total_luas'),
            DB::raw('SUM(tkds.harga_dasar) as total_harga_dasar'),
            DB::raw('SUM(penawarans.nilai_penawaran) as total_nilai_penawaran'),
            DB::raw('COUNT(DISTINCT daftars.id) as total_daftar'),
            DB::raw('COUNT(DISTINCT penawarans.id) as total_penawaran'),
            DB::raw('(SELECT COUNT(DISTINCT t.id) FROM tkds t
                        LEFT JOIN penawarans p ON t.id = p.idfk_tkd
                      WHERE p.idfk_tkd IS NULL AND t.id_kelurahan = kelurahans.id) as total_tidak_laku')
        )
            ->leftJoin('kelurahans', 'tkds.id_kelurahan', '=', 'kelurahans.id')
            ->leftJoin('penawarans', 'penawarans.idfk_tkd', '=', 'tkds.id')
            ->leftJoin('daftars', 'daftars.id_kelurahan', '=', 'kelurahans.id')
            ->groupBy('kelurahans.kelurahan')
            ->get();

        $cetakSekotaKecamatan = Tkd::select(
            'kecamatans.kecamatan',
            DB::raw('SUM(tkds.luas) as total_luas'),
            DB::raw('SUM(tkds.harga_dasar) as total_harga_dasar'),
            DB::raw('SUM(penawarans.nilai_penawaran) as total_nilai_penawaran'),
            //     DB::raw('COUNT(DISTINCT daftars.id) as total_daftar'),
            //     DB::raw('COUNT(DISTINCT penawarans.id) as total_penawaran'),
            //     DB::raw('(SELECT COUNT(DISTINCT t.id) FROM tkds t
            //                     LEFT JOIN penawarans p ON t.id = p.idfk_tkd
            //                   WHERE p.idfk_tkd IS NULL AND t.id_kelurahan = kelurahans.id) as total_tidak_laku')
        )
            ->leftJoin('kelurahans', 'tkds.id_kelurahan', '=', 'kelurahans.id')
            ->leftJoin('kecamatans', 'kelurahans.id_kecamatan', '=', 'kecamatans.id')
            ->leftJoin('penawarans', 'penawarans.idfk_tkd', '=', 'tkds.id')
            // ->leftJoin('daftars', 'daftars.id_kelurahan', '=', 'kelurahans.id')
            ->groupBy('kelurahans.id_kecamatan')
            ->get();

        $pdf = PDF::loadview(
            'lelang.penawaran.rekap-sekota',
            [
                'cetakSekota' => $cetakSekota,
                'cetakSekotaKecamatan' => $cetakSekotaKecamatan,
            ]
        );
        return $pdf->stream();
    }
}
