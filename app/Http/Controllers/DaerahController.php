<?php

namespace App\Http\Controllers;

use App\Exports\DaerahsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportBaRequest;
use App\Http\Requests\ImportDaerahRequest;
use App\Http\Requests\StoreDaerahRequest;
use App\Http\Requests\UpdateDaerahRequest;
use App\Imports\DaerahsImport;
use App\Models\Daerah;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DaerahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:daerah.index')->only('index');
        $this->middleware('permission:daerah.create')->only('create', 'store');
        $this->middleware('permission:daerah.edit')->only('edit', 'update');
        $this->middleware('permission:daerah.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $kecamatan = Kecamatan::all();
        $kelurahan = Kelurahan::all();
        $tanggal_lelang = $request->input('tanggal_lelang');
        $kecamatanSelected = $request->input('kecamatan');
        $kelurahanSelected = $request->input('kelurahan');

        $daerahs = DB::table('daerahs')
            ->select(
                'daerahs.id',
                'daerahs.tanggal_lelang',
                'daerahs.id_kelurahan',
                'daerahs.id_kecamatan',
                'daerahs.noba',
                'daerahs.periode',
                'daerahs.thn_sts',
                'daerahs.surat',
                'daerahs.surat_shp',
                'kelurahans.kelurahan',
                'kecamatans.kecamatan',
                'tahuns.tahun'
            )
            ->leftJoin('kecamatans', 'daerahs.id_kecamatan', '=', 'kecamatans.id')
            ->leftJoin('kelurahans', 'daerahs.id_kelurahan', '=', 'kelurahans.id')
            ->leftJoin('tahuns', 'daerahs.thn_sts', '=', 'tahuns.id')
            ->when($request->kecamatan, function ($query, $kecamatan) {
                return $query->where('daerahs.id_kecamatan', $kecamatan);
            })
            ->when($request->kelurahan, function ($query, $kelurahan) {
                return $query->where('daerahs.id_kelurahan', $kelurahan);
            })

            ->whereNull('daerahs.deleted_at')
            ->paginate(10);
        return view('master data.daerah.index')->with([
            'daerahs' => $daerahs,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'kecamatanSelected' => $kecamatanSelected,
            'kelurahanSelected' => $kelurahanSelected,
            'tanggal_lelang' => $tanggal_lelang,
        ]);
    }

    public function create()
    {
        $kelurahans = Kelurahan::all();
        $kecamatans = Kecamatan::all();
        $tahuns = Tahun::all();
        return view('master data.daerah.create')->with(['kecamatans' => $kecamatans, 'kelurahans' => $kelurahans, 'tahuns' => $tahuns]);
    }

    public function store(StoreDaerahRequest $request)
    {
        Daerah::create([
            'id_kecamatan' => $request->id_kecamatan,
            'id_kelurahan' => $request->id_kelurahan,
            'noba' => $request->noba,
            'periode' => $request->periode,
            'thn_sts' => $request->id_tahun,
            'tanggal_lelang' => $request->tanggal_lelang,
        ]);
        return redirect()->route('daerah.index')->with('success', 'Tambah Data Daerah Sukses');
    }

    public function storeJquery(StoreDaerahRequest $request)
    {
        Daerah::create([
            'id_kecamatan' => $request->id_kecamatan,
            'id_kelurahan' => $request->id_kelurahan,
            'noba' => $request->noba,
            'periode' => $request->periode,
            'thn_sts' => $request->thn_sts,
            'tanggal_lelang' => $request->tanggal_lelang,
        ]);

        return response()->json(['success' => true, 'message' => 'Tambah Data Daerah Sukses']);
    }


    public function show(Daerah $daerah)
    {
        return view('master data.daerah.show', compact('daerah'));
    }

    public function edit(Daerah $daerah)
    {
        $kelurahans = Kelurahan::all();
        $kecamatans = Kecamatan::all();
        $tahuns = Tahun::all();
        return view('master data.daerah.edit', compact('daerah'))->with(['kecamatans' => $kecamatans, 'kelurahans' => $kelurahans,  'tahuns' => $tahuns]);
    }

    public function update(UpdateDaerahRequest $request, Daerah $daerah)
    {
        $daerah->update($request->all());
        return redirect()->route('daerah.index')
            ->with('success', 'Daerah Lelang updated successfully.');
    }

    public function destroy(Daerah $daerah)
    {
        try {
            $daerah->delete();
            return redirect()->route('daerah.index')->with('success', 'Hapus Data Daerah Sukses');
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1451) {
                return redirect()->route('daerah.index')
                    ->with('error', 'Tidak Dapat Menghapus Daerah Yang Masih Digunakan Oleh Kolom Lain');
            } else {
                return redirect()->route('daerah.index')->with('success', 'Hapus Data Daerah Sukses');
            }
        }
    }

    public function getKelurahans(Request $request)
    {



        $kelurahans = Kelurahan::all()->where('id_kecamatan', $request->kecamatan_id);

        return response()->json(['kelurahans' => $kelurahans]);
    }

    public function import(ImportDaerahRequest $request)
    {
        Excel::import(new DaerahsImport, $request->file('import-file')->store('import-files'));
        return redirect()->route('daerah.index')->with('success', 'Tambahkan Data Daerah Sukses diimport');
    }

    public function export()
    {
        return Excel::download(new DaerahsExport, 'Daerah.xlsx');
    }

    public function downloadTemplate()
    {
        $templatePath = public_path('Excel/templates/daerah_template.xlsx');
        if (!file_exists($templatePath)) {
            return redirect()->route('daerah.index')->with('error', 'Template file not found.');
        }

        return response()->download($templatePath, 'daerah_template.xlsx');
    }



    public function getDaerahJquery()
    {
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::where('id', $selectedTahunId)->value('id');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $daerah = Daerah::select(
            'daerahs.id',
            'daerahs.tanggal_lelang',
            'daerahs.id_kelurahan',
            'daerahs.id_kecamatan',
            'daerahs.noba',
            'daerahs.periode',
            'daerahs.thn_sts',
            'kelurahans.kelurahan',
            'kecamatans.kecamatan',
            'tahuns.tahun'
        )
            ->leftJoin('kecamatans', 'daerahs.id_kecamatan', '=', 'kecamatans.id')
            ->leftJoin('kelurahans', 'daerahs.id_kelurahan', '=', 'kelurahans.id')
            ->leftJoin('tahuns', 'daerahs.thn_sts', '=', 'tahuns.id')
            ->where('daerahs.id_kelurahan', $daftarIdFromSession)
            ->where('daerahs.thn_sts', $tahunSelected)
            ->first();
        return response()->json([
            'daerah' => $daerah,
        ]);
    }

    public function uploadSurat(ImportBaRequest $request)
    {
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::where('id', $selectedTahunId)->value('id');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');

        $daerah = Daerah::where('id_kelurahan', $daftarIdFromSession)
            ->where('thn_sts', $tahunSelected)
            ->first();

        if ($daerah) {
            $file = $request->file('import-file');

            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('public/surat', $filename);


            $daerah->surat = $filename;
            $daerah->save();

            return back()->with('success', 'Surat berhasil diunggah dan data diperbarui.');
        } else {
            return back()->with('error', 'Data daerah tidak ditemukan.');
        }
    }

    public function uploadSuratSHP(ImportBaRequest $request)
    {
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::where('id', $selectedTahunId)->value('id');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');

        $daerah = Daerah::where('id_kelurahan', $daftarIdFromSession)
            ->where('thn_sts', $tahunSelected)
            ->first();

        if ($daerah) {
            $file = $request->file('import-file');

            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('public/surat', $filename);


            $daerah->surat_shp = $filename;
            $daerah->save();

            return back()->with('success', 'Surat berhasil diunggah dan data diperbarui.');
        } else {
            return back()->with('error', 'Data daerah tidak ditemukan.');
        }
    }

    public function editLoadKelurahan(Request $request)
    {
        $kelurahan['Kelurahan'] = Kelurahan::all()->where('id_kecamatan', $request->id_kecamatan);
        return response()->json($kelurahan);
    }

    public function kelurahanFilter(Request $request)
    {
        $kelurahan['Kelurahan'] = Kelurahan::where('id_kecamatan', $request->id_kecamatan)->get();
        return response()->json($kelurahan);
    }
}
