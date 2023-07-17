<?php

namespace App\Http\Controllers;

use App\Models\DaerahLelang;
use App\Http\Requests\StoreDaerahLelangRequest;
use App\Http\Requests\UpdateDaerahLelangRequest;
use Illuminate\Http\Request;

class DaerahLelangController extends Controller
{
    public function index()
    {
        $daerah_lelangs = DaerahLelang::all();
        return view('master data.daerah lelang.index', compact('daerah_lelangs'));
    }

    public function create()
    {
        return view('master data.daerah lelang.create');
    }

    public function store(StoreDaerahLelangRequest $request)
    {
        DaerahLelang::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('master data.daerah lelang.index')->with('success', 'Data Daerah Lelang berhasil ditambahkan.');
    }

    public function show(DaerahLelang $daerah_lelang)
    {
        return view('master data.daerah lelang.show', compact('daerah_lelang'));
    }

    public function edit(DaerahLelang $daerah_lelang)
    {
        return view('master data.daerah lelang.edit', compact('daerah_lelang'));
    }

    public function update(UpdateDaerahLelangRequest $request, DaerahLelang $daerah_lelang)
    {
        $daerah_lelang->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('master data.daerah lelang.index')->with('success', 'Data Daerah Lelang berhasil diperbarui.');
    }

    public function destroy(DaerahLelang $daerah_lelang)
    {
        try {
            $daerah_lelang->delete();
            return redirect()->route('master data.daerah lelang.index')->with('success', 'Hapus Data Daerah Lelang Sukses');
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1451) {
                return redirect()->route('master data.daerah lelang.index')
                    ->with('error', 'Tidak Dapat Menghapus Daerah Lelang Yang Masih Digunakan Oleh Kolom Lain');
            } else {
                return redirect()->route('master data.daerah lelang.index')->with('success', 'Hapus Data Daerah Lelang Sukses');
            }
        }
    }
}
