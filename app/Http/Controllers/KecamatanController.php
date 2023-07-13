<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKecamatanRequest;
use App\Http\Requests\UpdateKecamatanRequest;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KecamatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:kecamatan.index')->only('index');
        $this->middleware('permission:kecamatan.create')->only('create', 'store');
        $this->middleware('permission:kecamatan.edit')->only('edit', 'update');
        $this->middleware('permission:kecamatan.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $kecamatans = DB::table('kecamatans')
            ->when($request->input('kecamatan'), function ($query, $kecamatan) {
                return $query->where('kecamatan', 'like', '%' . $kecamatan . '%');
            })
            ->paginate(10);
        return view('master data.kecamatan.index', compact('kecamatans'));
    }

    public function create()
    {
        return view('master data.kecamatan.create');
    }

    public function store(StoreKecamatanRequest $request)
    {
        Kecamatan::create([
            'kecamatan' => $request->kecamatan,
        ]);
        return redirect()->route('kecamatan.index')->with('success', 'Tambah Data Barang Sukses');
    }

    public function show(Kecamatan $kecamatan)
    {
        return view('master data.kecamatan.show', compact('kecamatan'));
    }

    public function edit(Kecamatan $kecamatan)
    {
        return view('master data.kecamatan.edit', compact('kecamatan'));
    }

    public function update(UpdateKecamatanRequest $request, Kecamatan $kecamatan)
    {
        $request->validate([
            'kecamatan' => 'required|unique:kecamatans,kecamatan,' . $kecamatan->id,
        ]);

        $kecamatan->update($request->all());

        return redirect()->route('kecamatan.index')
            ->with('success', 'Kecamatan updated successfully.');
    }

    public function destroy(Kecamatan $kecamatan)
    {
        try {
            $kecamatan->delete();
            return redirect()->route('kecamatan.index')->with('success', 'Hapus Data Kecamatan Sukses');
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1451) {
                return redirect()->route('kecamatan.index')
                    ->with('error', 'Tidak Dapat Menghapus Kecamatan Yang Masih Digunakan Oleh Kolom Lain');
            } else {
                return redirect()->route('kecamatan.index')->with('success', 'Hapus Data Kecamatan Sukses');
            }
        }
    }
}
