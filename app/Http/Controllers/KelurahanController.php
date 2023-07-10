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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kecamatans = Kecamatan::all();
        $kelurahans = $request->input('kelurahans');
        $kelurahans = DB::table('kelurahans')
            ->select(
                'kelurahans.id',
                'kelurahans.id_kecamatan',
                'kelurahans.kelurahan',
                'kecamatans.kecamatan',
            )
            ->leftJoin('kecamatans', 'kelurahans.id_kecamatan', '=', 'kecamatans.id')
            ->when($request->input('kelurahans'), function ($query, $kelurahans) {
                return $query->where('kelurahans', 'like', '%' . $kelurahans . '%');
            })
            ->when($request->input('kecamatans'), function ($query, $kecamatans) {
                return $query->whereIn('kelurahans.id_kecamatan', $kecamatans);
            })
            ->orderBy('kelurahans.id_kecamatan', 'asc')
            ->paginate(5);
        $kecamatanSelected = $request->input('kecamatan');
        return view('master data.kelurahan.index')->with([
            'kelurahans' => $kelurahans,
            'kecamatan' => $kecamatans,
            'kecamatanSelected' => $kecamatanSelected,
            'kelurahan' => $kelurahans,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kecamatans=Kecamatan::all();
        return view('master data.kelurahan.create')->with(['kecamatans'=> $kecamatans]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKelurahanRequest $request)
    {
        Kelurahan::create([
            'kelurahan' => $request->kelurahan,
            'id_kecamatan' => $request->id_kecamatan,
        ]);

        return redirect()->route('kelurahan.index')
            ->with('success', 'Kelurahan created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
    public function show(Kelurahan $kelurahan)
    {
        return view('master data.kelurahan.show', compact('kelurahan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
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
