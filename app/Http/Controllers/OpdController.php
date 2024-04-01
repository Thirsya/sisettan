<?php

namespace App\Http\Controllers;

use App\Exports\OpdsExport;
use App\Http\Requests\ImportOpdRequest;
use App\Http\Requests\StoreopdRequest;
use App\Http\Requests\UpdateopdRequest;
use App\Imports\OpdsImport;
use App\Models\Kecamatan;
use App\Models\OPD;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OPDController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:opd.index')->only('index');
        $this->middleware('permission:opd.create')->only('create', 'store');
        $this->middleware('permission:opd.edit')->only('edit', 'update');
        $this->middleware('permission:opd.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $kecamatans = Kecamatan::all();
        $opdName = $request->input('opd');
        $kecamatanIds = $request->input('kecamatan');
        $opd = $request->input('opd');

        $query = Opd::select('opds.id', 'opds.id_kecamatan', 'opds.no_opd', 'kecamatans.kecamatan')
            ->leftJoin('kecamatans', 'opds.id_kecamatan', '=', 'kecamatans.id')
            ->when($request->input('opd'), function ($query, $opd) {
                return $query->where('opds.no_opd', 'like', '%' . $opd . '%');
            })
            ->when($request->input('kecamatan'), function ($query, $kecamatan) {
                return $query->whereIn('opds.id_kecamatan', $kecamatan);
            })
            // ->orderBy('opds.id_kecamatan', 'asc')
            ->whereNull('opds.deleted_at')
            ->paginate(10);
        $kecamatanSelected = $request->input('kecamatan');

        $query->appends(['opd' => $opdName, 'kecamatan' => $kecamatanIds]);

        return view('users.opd.index')->with([
            'opds' => $query,
            'kecamatans' => $kecamatans,
            'opdName' => $opdName,
            'kecamatanIds' => $kecamatanIds,
            'kecamatanSelected' => $kecamatanSelected,
            'opd' => $opd,
        ]);
    }

    public function create()
    {
        $kecamatans = Kecamatan::all();
        return view('users.opd.create')->with(['kecamatans' => $kecamatans]);
    }

    public function store(StoreopdRequest $request)
    {
        Opd::create($request->validated());
        return redirect()->route('opd.index')->with('success', 'OPD created successfully.');
    }

    public function show(Opd $opd)
    {
        return view('users.opd.show', compact('opd'));
    }

    public function edit(Opd $opd)
    {
        $kecamatans = Kecamatan::all();
        return view('users.opd.edit', compact('opd'))->with(
            ['no_opd' => $opd, 'nama_opd' => $opd, 'kecamatans' => $kecamatans]
        );
    }

    public function update(UpdateopdRequest $request, Opd $opd)
    {
        $opd->update($request->validated());
        return redirect()->route('opd.index')->with('success', 'OPD updated successfully.');
    }

    public function destroy(Opd $opd)
    {
        try {
            $opd->delete();
            return redirect()->route('opd.index')->with('success', 'Hapus Data OPD Sukses');
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1451) {
                return redirect()->route('opd.index')
                    ->with('error', 'Tidak Dapat Menghapus OPD Yang Masih Digunakan Oleh Kolom Lain');
            } else {
                return redirect()->route('opd.index')->with('success', 'Hapus Data OPD Sukses');
            }
        }
    }

    public function import(ImportOpdRequest $request)
    {
        Excel::import(new OpdsImport, $request->file('import-file')->store('import-files'));
        return redirect()->route('opd.index')->with('success', 'Tambahkan Data OPD Sukses diimport');
    }

    public function export()
    {
        return Excel::download(new OpdsExport, 'OPD.xlsx');
    }
}
