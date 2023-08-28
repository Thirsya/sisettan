<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportTahunRequest;
use App\Http\Requests\StoreTahunRequest;
use App\Http\Requests\UpdateTahunRequest;
use App\Exports\TahunsExport;
use App\Imports\TahunsImport;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TahunController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:tahun.index')->only('index');
        $this->middleware('permission:tahun.create')->only('create', 'store');
        $this->middleware('permission:tahun.edit')->only('edit', 'update');
        $this->middleware('permission:tahun.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $tahuns = DB::table('tahuns')
            ->when($request->input('tahun'), function ($query, $tahun) {
                return $query->where('tahun', 'like', '%' . $tahun . '%');
            })
            ->whereNull('tahuns.deleted_at')
            ->paginate(10);
        return view('master data.tahun.index', compact('tahuns'));
    }

    public function create()
    {
        return view('master data.tahun.create');
    }

    public function store(StoreTahunRequest $request)
    {
        Tahun::create([
            'tahun' => $request->tahun,
        ]);
        return redirect()->route('tahun.index')->with('success', 'Tambah Data Barang Sukses');
    }

    public function show(Tahun $tahun)
    {
        return view('tahun.show', compact('tahun'));
    }

    public function edit(Tahun $tahun)
    {
        return view('master data.tahun.edit')->with([
            'tahun' => $tahun
        ]);
    }

    public function update(UpdateTahunRequest $request, Tahun $tahun)
    {
        $request->validate([
            'tahun' => 'required|unique:tahuns,tahun,' . $tahun->id,
        ]);

        $tahun->update($request->all());

        return redirect()->route('tahun.index')
            ->with('success', 'Tahun updated successfully.');
    }

    public function destroy(Tahun $tahun)
    {
        $tahun->delete();

        return redirect()->route('tahun.index')
            ->with('success', 'Tahun deleted successfully.');
    }

    public function import(ImportTahunRequest $request)
    {
        Excel::import(new TahunsImport, $request->file('import-file')->store('import-files'));
        return redirect()->route('tahun.index')->with('success', 'Tambahkan Data Tahun Sukses diimport');
    }

    public function export()
    {
        return Excel::download(new TahunsExport, 'Tahun.xlsx');
    }
}
