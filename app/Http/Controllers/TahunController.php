<?php

namespace App\Http\Controllers;

use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TahunController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:tahun.index')->only('index');
        $this->middleware('permission:tahun.create')->only('create', 'store');
        $this->middleware('permission:tahun.edit')->only('edit', 'update');
        $this->middleware('permission:tahun.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahuns = DB::table('tahuns')->paginate(5);
        return view('master data.tahun.index', compact('tahuns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tahuns.create');
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
            'tahun' => 'required|unique:tahuns',
        ]);

        Tahun::create($request->all());

        return redirect()->route('tahuns.index')
            ->with('success', 'Tahun created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function show(Tahun $tahun)
    {
        return view('tahuns.show', compact('tahun'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function edit(Tahun $tahun)
    {
        return view('tahuns.edit', compact('tahun'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tahun $tahun)
    {
        $request->validate([
            'tahun' => 'required|unique:tahuns,tahun,' . $tahun->id,
        ]);

        $tahun->update($request->all());

        return redirect()->route('tahuns.index')
            ->with('success', 'Tahun updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tahun $tahun)
    {
        $tahun->delete();

        return redirect()->route('tahuns.index')
            ->with('success', 'Tahun deleted successfully.');
    }
}
