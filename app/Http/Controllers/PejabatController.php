<?php

namespace App\Http\Controllers;

use App\Models\Pejabat;
use App\Http\Requests\StorePejabatRequest;
use App\Http\Requests\UpdatePejabatRequest;
use Illuminate\Http\Request;

class PejabatController extends Controller
{
    public function index()
    {
        $pejabats = Pejabat::all();
        return view('pejabat.index', compact('pejabats'));
    }

    public function create()
    {
        return view('pejabat.create');
    }

    public function store(StorePejabatRequest $request)
    {
        Pejabat::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('pejabat.index')->with('success', 'Data Pejabat berhasil ditambahkan.');
    }

    public function show(Pejabat $pejabat)
    {
        return view('pejabat.show', compact('pejabat'));
    }

    public function edit(Pejabat $pejabat)
    {
        return view('pejabat.edit', compact('pejabat'));
    }

    public function update(UpdatePejabatRequest $request, Pejabat $pejabat)
    {
        $pejabat->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('pejabat.index')->with('success', 'Data Pejabat berhasil diperbarui.');
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
                    ->with('error', 'Tidak Dapat Menghapus Pejabat Yang Masih Digunakan Oleh Kolom Lain');
            } else {
                return redirect()->route('pejabat.index')->with('success', 'Hapus Data Pejabat Sukses');
            }
        }
    }
}
