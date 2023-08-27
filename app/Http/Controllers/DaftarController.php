<?php

namespace App\Http\Controllers;

use App\Exports\DaftarsExport;
use App\Http\Requests\ImportDaftarRequest;
use App\Models\Daftar;
use App\Http\Requests\StoreDaftarRequest;
use App\Http\Requests\UpdateDaftarRequest;
use App\Imports\DaftarsImport;
use App\Models\Daerah;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class DaftarController extends Controller
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
        $kelurahans = Kelurahan::all();
        $daftarName = $request->input('daftar');
        $requestedKelurahanIds = $request->input('kelurahan');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id', $daftarIdFromSession)->pluck('id_kelurahan')->first();
        $daftarQuery = daftar::select(
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
            ->when($request->input('nama'), function ($query, $nama) {
                return $query->where('daftars.nama', 'like', '%' . $nama . '%');
            })
            ->when($requestedKelurahanIds, function ($query, $kelurahanIds) {
                return $query->whereIn('daftars.id_kelurahan', $kelurahanIds);
            })
            ->where('daftars.id_kelurahan', $kelurahanIdFromDaerah)
            ->whereNull('daftars.deleted_at')

            ->orderByRaw("CAST(daftars.no_urut AS SIGNED) ASC")
            ->paginate(10);
        $daftarQuery->appends(['daftar' => $daftarName, 'kelurahan' => $requestedKelurahanIds]);
        return view('lelang.daftar.index')->with([
            'daftars' => $daftarQuery,
            'kelurahans' => $kelurahans,
            'daftarName' => $daftarName,
            'requestedKelurahanIds' => $requestedKelurahanIds,
            'kelurahanSelected' => $requestedKelurahanIds,
            'daftar' => $daftarName
        ]);
    }

    public function create()
    {
        $kelurahanId = session('kelurahan_id');
        $kelurahans = Kelurahan::all();
        return view('lelang.daftar.create')->with([
            'kelurahans' => $kelurahans,
            'kelurahanId' => $kelurahanId,
        ]);
    }


    public function store(StoreDaftarRequest $request)
    {
        $validatedData = $request->validated();
        $idKelurahan = $validatedData['id_kelurahan'];
        $noUrut = $validatedData['no_urut'];

        $idDaftar = $idKelurahan . "P" . $noUrut;

        while (Daftar::where('id_daftar', $idDaftar)->exists()) {
            $noUrut++;
            $idDaftar = $idKelurahan . $noUrut;
        }
        $validatedData['id_daftar'] = $idDaftar;

        Daftar::create($validatedData);

        return redirect()->route('daftar.index')->with('success', 'Daftar created successfully.');
    }


    public function show(Daftar $daftar)
    {
        return view('lelang.daftar.show', compact('daftar'));
    }

    public function edit(Daftar $daftar)
    {
        $kelurahans = Kelurahan::all();
        return view('lelang.daftar.edit', compact('daftar'))->with(['kelurahans' => $kelurahans]);
    }

    public function update(UpdateDaftarRequest $request, Daftar $daftar)
    {
        $daftar->update($request->validated());
        return redirect()->route('daftar.index')->with('success', 'Daftar updated successfully.');
    }

    public function destroy(Daftar $daftar)
    {
        $daftar->delete();
        return redirect()->route('daftar.index')->with('success', 'Daftar deleted successfully.');
    }

    public function import(ImportDaftarRequest $request)
    {
        Excel::import(new DaftarsImport, $request->file('import-file')->store('import-files'));
        return redirect()->route('daftar.index')->with('success', 'Tambahkan Data Daftar Sukses diimport');
    }

    public function export()
    {
        return Excel::download(new DaftarsExport, 'Daftar.xlsx');
    }

    public function getLatestNoUrut(Request $request)
    {
        $latestDaftar = Daftar::where('id_kelurahan', $request->id)
            ->orderByRaw("CAST(daftars.no_urut AS SIGNED) DESC")
            ->first();

        return $latestDaftar ? $latestDaftar->no_urut + 1 : 1;
    }

    public function downloadTemplate()
    {
        $templatePath = public_path('Excel/templates/daftar_template.xlsx');
        if (!file_exists($templatePath)) {
            return redirect()->route('daftar.index')->with('error', 'Template file not found.');
        }

        return response()->download($templatePath, 'daftar_template.xlsx');
    }
}
