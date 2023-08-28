<?php

namespace App\Http\Controllers;

use App\Exports\JabatansExport;
use App\Http\Requests\StoreJabatanRequest;
use App\Http\Requests\UpdateJabatanRequest;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ImportJabatanRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\JabatansImport;

class JabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:jabatan.index')->only('index');
        $this->middleware('permission:jabatan.create')->only('create', 'store');
        $this->middleware('permission:jabatan.edit')->only('edit', 'update');
        $this->middleware('permission:jabatan.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $jabatans = DB::table('jabatans')
            ->when($request->input('jabatan'), function ($query, $jabatan) {
                return $query->where('jabatan', 'like', '%' . $jabatan . '%');
            })
            ->whereNull('jabatans.deleted_at')
            ->paginate(10);
        return view('users.jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        return view('users.jabatan.create');
    }

    public function store(StoreJabatanRequest $request)
    {
        Jabatan::create([
            'jabatan' => $request->jabatan,
        ]);
        return redirect()->route('jabatan.index')->with('success', 'Tambah Data Jabatan Sukses');
    }

    public function show(Jabatan $jabatan)
    {
        return view('users.jabatan.show', compact('jabatan'));
    }

    public function edit(Jabatan $jabatan)
    {
        return view('users.jabatan.edit', compact('jabatan'));
    }

    public function update(UpdateJabatanRequest $request, Jabatan $jabatan)
    {
        $request->validate([
            'jabatan' => 'required|unique:jabatans,jabatan,' . $jabatan->id,
        ]);

        $jabatan->update($request->all());

        return redirect()->route('jabatan.index')
            ->with('success', 'Jabatan updated successfully.');
    }

    public function destroy(Jabatan $jabatan)
    {
        try {
            $jabatan->delete();
            return redirect()->route('jabatan.index')->with('success', 'Hapus Data Jabatan Sukses');
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1451) {
                return redirect()->route('jabatan.index')
                    ->with('error', 'Tidak Dapat Menghapus Jabatan Yang Masih Digunakan Oleh Kolom Lain');
            } else {
                return redirect()->route('jabatan.index')->with('success', 'Hapus Data Jabatan Sukses');
            }
        }
    }

    public function import(ImportJabatanRequest $request)
    {
        Excel::import(new JabatansImport, $request->file('import-file')->store('import-files'));
        return redirect()->route('jabatan.index')->with('success', 'Tambahkan Data Jabatan Sukses diimport');
    }

    public function export()
    {
        return Excel::download(new JabatansExport, 'Jabatan.xlsx');
    }
}
