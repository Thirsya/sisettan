<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
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
        return view('kelurahans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kelurahan' => 'required|unique:kelurahans',
        ]);

        Kelurahan::create($request->all());

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
        return view('kelurahans.show', compact('kelurahan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelurahan $kelurahan)
    {
        return view('kelurahans.edit', compact('kelurahan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelurahan $kelurahan)
    {
        $request->validate([
            'kelurahan' => 'required|unique:kelurahans,kelurahan,' . $kelurahan->id,
        ]);

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
        $kelurahan->delete();

        return redirect()->route('kelurahan.index')
            ->with('success', 'Kelurahan deleted successfully.');
    }
}
