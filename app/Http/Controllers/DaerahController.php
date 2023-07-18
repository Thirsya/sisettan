<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDaerahRequest;
use App\Http\Requests\UpdateDaerahRequest;
use App\Models\Daerah;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DaerahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:daerah.index')->only('index');
        $this->middleware('permission:daerah.create')->only('create', 'store');
        $this->middleware('permission:daerah.edit')->only('edit', 'update');
        $this->middleware('permission:daerah.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $kecamatans = Kecamatan::all();
        $tanggal_lelang = $request->input('tanggal_lelang');
        $daerahs = DB::table('daerahs')
            ->select(
                'daerahs.id',
                'daerahs.tanggal_lelang',
                'daerahs.id_kelurahan',
                'daerahs.id_kecamatan',
                'kelurahans.kelurahan',
                'kecamatans.kecamatan',
            )
            ->leftJoin('kecamatans', 'daerahs.id_kecamatan', '=', 'kecamatans.id')
            ->leftJoin('kelurahans', 'daerahs.id_kelurahan', '=', 'kelurahans.id')
            ->when($request->input('kelurahan'), function ($query, $kelurahan) {
                return $query->where('kelurahan', 'like', '%' . $kelurahan . '%');
            })
            ->when($request->input('kecamatan'), function ($query, $kecamatan) {
                return $query->whereIn('daerah.jenis_barang_id', $kecamatan);
            })
            // ->orderBy('daerah.kode_jbs', 'asc')
            ->paginate(10);
        $kecamatanSelected = $request->input('kecamatan');
        return view('master data.daerah.index')->with([
            'daerahs' => $daerahs,
            'kecamatans' => $kecamatans,
            'kecamatanSelected' => $kecamatanSelected,
            'tanggal_lelang' => $tanggal_lelang,
        ]);
    }

    public function create()
    {
        $kelurahans = Kelurahan::all();
        $kecamatans = Kecamatan::all();
        return view('master data.daerah.create')->with(['kecamatans' => $kecamatans, 'kelurahans' => $kelurahans]);
    }

    public function store(StoreDaerahRequest $request)
    {
        Daerah::create([
            'id_kecamatan' => $request->id_kecamatan,
            'id_kelurahan' => $request->id_kelurahan,
            'tanggal_lelang' => $request->tanggal_lelang,
        ]);
        return redirect()->route('daerah.index')->with('success', 'Tambah Data Daerah Sukses');
    }

    public function show(Daerah $daerah)
    {
        return view('master data.daerah.show', compact('daerah'));
    }

    public function edit(Daerah $daerah)
    {
        $kelurahans = Kelurahan::all();
        $kecamatans = Kecamatan::all();
        return view('master data.daerah.edit', compact('daerah'))->with(['kecamatans' => $kecamatans, 'kelurahans' => $kelurahans]);
    }

    public function update(UpdateDaerahRequest $request, Daerah $daerah)
    {
        $daerah->update($request->all());
        return redirect()->route('daerah.index')
            ->with('success', 'Daerah Lelang updated successfully.');
    }

    public function destroy(Daerah $daerah)
    {
        try {
            $daerah->delete();
            return redirect()->route('daerah.index')->with('success', 'Hapus Data Daerah Sukses');
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1451) {
                return redirect()->route('daerah.index')
                    ->with('error', 'Tidak Dapat Menghapus Daerah Yang Masih Digunakan Oleh Kolom Lain');
            } else {
                return redirect()->route('daerah.index')->with('success', 'Hapus Data Daerah Sukses');
            }
        }
    }

    public function getKelurahans(Request $request)
    {
        // $kecamatanId = $request->input('kecamatan_id');

        // Fetch the kelurahans based on the selected kecamatan
        $kelurahans = Kelurahan::all()->where('id_kecamatan', $request->kecamatan_id);

        return response()->json(['kelurahans' => $kelurahans]);
    }
}
