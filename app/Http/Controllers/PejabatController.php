<?php

namespace App\Http\Controllers;

use App\Exports\PejabatsExport;
use App\Http\Requests\ImportPejabatRequest;
use App\Models\Pejabat;
use App\Http\Requests\StorePejabatRequest;
use App\Http\Requests\UpdatePejabatRequest;
use App\Imports\PejabatsImport;
use App\Models\Jabatan;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PejabatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:pejabat.index')->only('index');
        $this->middleware('permission:pejabat.create')->only('create', 'store');
        $this->middleware('permission:pejabat.edit')->only('edit', 'update');
        $this->middleware('permission:pejabat.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $jabatans = Jabatan::all();
        $id_kecamatan = $request->input('id_kecamatan');
        $pejabatSearch = $request->input('pejabat');
        $pejabats = DB::table('pejabats')
            ->select(
                'pejabats.id',
                'pejabats.nama_pejabat',
                'pejabats.id_jabatan',
                'pejabats.id_opd',
                'pejabats.nip_pejabat',
                'pejabats.no_sk',
                'opds.id_kecamatan',
                'jabatans.jabatan',
            )
            ->leftJoin('jabatans', 'pejabats.id_jabatan', '=', 'jabatans.id')
            ->leftJoin('opds', 'pejabats.id_opd', '=', 'opds.id')
            ->when($request->input('pejabat'), function ($query, $pejabat) {
                return $query->where('pejabats.nama_pejabat', 'like', '%' . $pejabat . '%');
            })
            ->whereNull('pejabats.deleted_at')
            ->paginate(10);
        $jabatanSelected = $request->input('jabatan');
        return view('users.pejabat.index')->with([
            'pejabatSearch' => $pejabatSearch,
            'pejabats' => $pejabats,
            'jabatans' => $jabatans,
            'jabatanSelected' => $jabatanSelected,
            'id_kecamatan' => $id_kecamatan,
        ]);
    }

    public function create()
    {
        $jabatans = Jabatan::all();
        $opds = Opd::all();
        return view('users.pejabat.create')->with(['jabatans' => $jabatans, 'opds' => $opds]);
    }

    public function store(StorePejabatRequest $request)
    {
        Pejabat::create($request->validated());
        return redirect()->route('pejabat.index')->with('success', 'Pejabat created successfully.');
    }

    public function show(Pejabat $pejabat)
    {
        return view('users.pejabat.show', compact('pejabat'));
    }

    public function edit(Pejabat $pejabat)
    {
        $jabatans = Jabatan::all();
        $opds = Opd::all();
        return view('users.pejabat.edit', compact('pejabat'))->with(['jabatans' => $jabatans, 'opds' => $opds]);
    }

    public function update(UpdatePejabatRequest $request, Pejabat $pejabat)
    {
        $pejabat->update($request->all());
        return redirect()->route('pejabat.index')
            ->with('success', 'Pejabat updated successfully.');
    }

    public function destroy(Pejabat $pejabat)
    {
        try {
            $pejabat->delete();
            return redirect()->route('pejabat.index')->with('success', 'Hapus Data pejabat Sukses');
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1451) {
                return redirect()->route('pejabat.index')
                    ->with('error', 'Tidak Dapat Menghapus pejabat Yang Masih Digunakan Oleh Kolom Lain');
            } else {
                return redirect()->route('pejabat.index')->with('success', 'Hapus Data Pejabat Sukses');
            }
        }
    }

    public function import(ImportPejabatRequest $request)
    {
        Excel::import(new PejabatsImport, $request->file('import-file')->store('import-files'));
        return redirect()->route('pejabat.index')->with('success', 'Tambahkan Data Pejabat Sukses diimport');
    }

    public function export()
    {
        return Excel::download(new PejabatsExport, 'Pejabat.xlsx');
    }
}
