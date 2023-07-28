<?php

namespace App\Http\Controllers;

use App\Exports\DaftarsExport;
use App\Http\Requests\ImportDaftarRequest;
use App\Models\Daftar;
use App\Http\Requests\StoreDaftarRequest;
use App\Http\Requests\UpdateDaftarRequest;
use App\Imports\DaftarsImport;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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
        // Mendapatkan semua data yang telah divalidasi
        $validatedData = $request->validated();

        // Mengambil id_kelurahan dan nomor urut
        $id_kelurahan = $validatedData['id_kelurahan'];
        $no_urut = $validatedData['no_urut'];

        // Membuat id_daftar dari id_kelurahan dan no_urut
        $id_daftar = $id_kelurahan . "P" .$no_urut;

        // Memeriksa jika id_daftar sudah ada di database
        while(Daftar::where('id_daftar', $id_daftar)->exists()) {
            // Jika id_daftar sudah ada, tambahkan 1 ke no_urut dan buat id_daftar baru
            $no_urut++;
            $id_daftar = $id_kelurahan . $no_urut;
        }

        // Menambahkan id_daftar ke array validated data
        $validatedData['id_daftar'] = $id_daftar;

        // Membuat entri baru di database
        Daftar::create($validatedData);

        // Mengembalikan pengguna ke halaman index dengan pesan sukses
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
}
