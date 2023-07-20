<?php

namespace App\Http\Controllers;

use App\Models\Daftar;
use App\Http\Requests\StoreDaftarRequest;
use App\Http\Requests\UpdateDaftarRequest;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $kelurahanIds = $request->input('kelurahan');
        $daftar = $request->input('daftar');

        $query = daftar::select('daftars.id', 'daftars.id_kelurahan', 'daftars.no_urut', 'daftars.nama', 'daftars.alamat',
        'daftars.no_kk', 'daftars.no_wp', 'daftars.tgl_perjanjian', 'kelurahans.kelurahan')
            ->leftJoin('kelurahans', 'daftars.id_kelurahan', '=', 'kelurahans.id')
            ->when($request->input('nama'), function ($query, $nama) {
                return $query->where('daftars.nama', 'like', '%' . $nama . '%');
            })
            ->when($request->input('kelurahan'), function ($query, $kelurahan) {
                return $query->whereIn('daftars.id_kelurahan', $kelurahan);
            })
            // ->orderBy('daftars.id_kelurahan', 'asc')
            ->paginate(10);
        $kelurahanSelected = $request->input('kelurahan');

        $query->appends(['daftar' => $daftarName, 'kelurahan' => $kelurahanIds]);

        return view('lelang.daftar.index')->with([
            'daftars' => $query,
            'kelurahans' => $kelurahans,
            'daftarName' => $daftarName,
            'kelurahanIds' => $kelurahanIds,
            'kelurahanSelected' => $kelurahanSelected,
            'daftar' => $daftar,
        ]);
    }

    public function create()
    {
        $kelurahans = Kelurahan::all();
        return view('lelang.daftar.create')->with(['kelurahans' => $kelurahans]);
    }

    public function store(StoreDaftarRequest $request)
    {
        Daftar::create($request->validated());
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
}
