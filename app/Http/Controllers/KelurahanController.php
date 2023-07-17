<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Http\Requests\StoreKelurahanRequest;
use App\Http\Requests\UpdateKelurahanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelurahanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:kelurahan.index')->only('index');
        $this->middleware('permission:kelurahan.create')->only('create', 'store');
        $this->middleware('permission:kelurahan.edit')->only('edit', 'update');
        $this->middleware('permission:kelurahan.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $kecamatans = Kecamatan::all();
        $kelurahanName = $request->input('kelurahan');
        $kecamatanIds = $request->input('kecamatan');
        $kelurahan = $request->input('kelurahan');

        $query = Kelurahan::select('kelurahans.id', 'kelurahans.id_kecamatan', 'kelurahans.kelurahan', 'kecamatans.kecamatan')
            ->leftJoin('kecamatans', 'kelurahans.id_kecamatan', '=', 'kecamatans.id')
            ->when($request->input('kelurahan'), function ($query, $kelurahan) {
                return $query->where('kelurahans.kelurahan', 'like', '%' . $kelurahan . '%');
            })
            ->when($request->input('kecamatan'), function ($query, $kecamatan) {
                return $query->whereIn('kelurahans.id_kecamatan', $kecamatan);
            })
            // ->orderBy('kelurahans.id_kecamatan', 'asc')
            ->paginate(5);
        $kecamatanSelected = $request->input('kecamatan');

        $query->appends(['kelurahan' => $kelurahanName, 'kecamatan' => $kecamatanIds]);

        return view('master data.kelurahan.index')->with([
            'kelurahans' => $query,
            'kecamatans' => $kecamatans,
            'kelurahanName' => $kelurahanName,
            'kecamatanIds' => $kecamatanIds,
            'kecamatanSelected' => $kecamatanSelected,
            'kelurahan' => $kelurahan,
        ]);
    }

    public function create()
    {
        $kecamatans=Kecamatan::all();
        return view('master data.kelurahan.create')->with(['kecamatans'=> $kecamatans]);
    }

    public function store(StoreKelurahanRequest $request)
    {
        Kelurahan::create([
            'kelurahan' => $request->kelurahan,
            'id_kecamatan' => $request->id_kecamatan,
        ]);

        return redirect()->route('kelurahan.index')
            ->with('success', 'Kelurahan created successfully.');
    }

    public function show(Kelurahan $kelurahan)
    {
        return view('master data.kelurahan.show', compact('kelurahan'));
    }

    public function edit(Kelurahan $kelurahan)
    {
        $kecamatans = Kecamatan::all();
        return view('master data.kelurahan.edit')->with(
            ['kelurahan' => $kelurahan,
            'kecamatans' => $kecamatans]
        );
    }

    public function update(UpdateKelurahanRequest $request, Kelurahan $kelurahan)
    {
        $kelurahan->update($request->all());

        return redirect()->route('kelurahan.index')
            ->with('success', 'Kelurahan updated successfully.');
    }

    public function destroy(Kelurahan $kelurahan)
    {
        try {
            $kelurahan->delete();
            return redirect()->route('kelurahan.index')->with('success', 'Hapus Data Kelurahan Sukses');
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1451) {
                return redirect()->route('kelurahan.index')
                    ->with('error', 'Tidak Dapat Menghapus Kelurahan Yang Masih Digunakan Oleh Kolom Lain');
            } else {
                return redirect()->route('kelurahan.index')->with('success', 'Hapus Data Kelurahan Sukses');
            }
        }
    }
}
