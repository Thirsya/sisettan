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
use App\Models\Tkd;
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
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id', $daftarIdFromSession)->pluck('id_kelurahan')->first();
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

    public function create()
    {
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id', $daftarIdFromSession)->pluck('id_kelurahan')->first();
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
        try {
            foreach ($request->nilai_penawaran as $tkdId => $value) {
                if (is_null($value)) {
                    continue;
                }
                $daftar = Daftar::find($request->idfk_daftar[$tkdId]);
                if (!$daftar) {
                    continue;
                }

                $idDaftar = $daftar->id_daftar;
                $idKelurahan = $daftar->id_kelurahan;
                $idTkd = Tkd::where('id', $tkdId)->pluck('id_tkd')->first();

                $idPenawaran = $idKelurahan . "X" . $idDaftar . $idTkd;

                $penawaran = Penawaran::create([
                    'id_penawaran' => $idPenawaran,
                    'total_luas' => 0,
                    'idfk_daftar' => $request->idfk_daftar[$tkdId],
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
            }

            return redirect()->route('penawaran.index')->with('success', 'Tambah Data Penawaran Sukses');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
        $kelurahanId = session('kelurahan_id');
        $tkds = Tkd::where('id_kelurahan', $kelurahanId)->get();
        $daftars = Daftar::where('id_kelurahan', $kelurahanId)->get();
        return view('lelang.penawaran.edit', compact('penawaran'))->with(['tkds' => $tkds, 'daftars' => $daftars]);
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
}
