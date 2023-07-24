<?php

namespace App\Http\Controllers;

use App\Models\Penawaran;
use App\Http\Requests\StorePenawaranRequest;
use App\Http\Requests\UpdatePenawaranRequest;
use App\Models\Daftar;
use App\Models\Tkd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenawaranController extends Controller
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
        $tkds = Tkd::all();
        $harga_dasar = $request->input('harga_dasar');
        $penawarans = DB::table('penawarans')
            ->select(
                'penawarans.id',
                'penawarans.id_daftar',
                'penawarans.id_tkd',
                'penawarans.nilai_penawaran',
                'penawarans.keterangan',
                'daftars.no_urut',
                'daftars.nama',
                'daftars.no_kk',
                'daftars.no_wp',
                'daftars.tgl_perjanjian',
                'tkds.bidang',
                'tkds.letak',
                'tkds.bukti',
                'tkds.harga_dasar',
                'tkds.luas',
                'tkds.keterangan',
                'tkds.nop',
            )
            ->leftJoin('tkds', 'penawarans.id_tkd', '=', 'tkds.id')
            ->leftJoin('daftars', 'penawarans.id_daftar', '=', 'daftars.id')
            ->when($request->input('no_urut'), function ($query, $no_urut) {
                return $query->where('no_urut', 'like', '%' . $no_urut . '%');
            })
            ->when($request->input('bukti'), function ($query, $bukti) {
                return $query->whereIn('daerah.jenis_barang_id', $bukti);
            })
            // ->orderBy('daerah.kode_jbs', 'asc')
            ->paginate(10);
        $tkdSelected = $request->input('bukti');
        return view('lelang.penawaran.index')->with([
            'penawarans' => $penawarans,
            'tkds' => $tkds,
            'tkdSelected' => $tkdSelected,
            'harga_dasar' => $harga_dasar,
        ]);
    }

    public function create()
    {
        // Kode untuk menampilkan form tambah penawaran (jika diperlukan)
        return view('penawaran.create');
    }

    public function store(StorePenawaranRequest $request)
    {
        Penawaran::create($request->validated());
        return redirect()->route('penawaran.index')->with('success', 'Penawaran created successfully.');
    }

    public function show(Penawaran $penawaran)
    {
        return view('penawaran.show', compact('penawaran'));
    }

    public function edit(Penawaran $penawaran)
    {
        return view('penawaran.edit', compact('penawaran'));
    }

    public function update(UpdatePenawaranRequest $request, Penawaran $penawaran)
    {
        $penawaran->update($request->validated());
        return redirect()->route('penawaran.index')->with('success', 'Penawaran updated successfully.');
    }

    public function destroy(Penawaran $penawaran)
    {
        $penawaran->delete();
        return redirect()->route('penawaran.index')->with('success', 'Penawaran deleted successfully.');
    }
}
