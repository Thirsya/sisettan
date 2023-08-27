<?php

namespace App\Http\Controllers;

use App\Exports\TkdsExport;
use App\Http\Requests\ImportTkdRequest;
use App\Models\Tkd;
use App\Http\Requests\StoreTkdRequest;
use App\Http\Requests\UpdateTkdRequest;
use App\Imports\TkdsImport;
use App\Models\Daerah;
use App\Models\Daftar;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TkdController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:tkd.index')->only('index');
        $this->middleware('permission:tkd.create')->only('create', 'store');
        $this->middleware('permission:tkd.edit')->only('edit', 'update');
        $this->middleware('permission:tkd.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $kelurahans = Kelurahan::all();
        $tkdName = $request->input('tkd');
        $kelurahanIds = $request->input('kelurahan');
        $tkd = $request->input('tkd');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id', $daftarIdFromSession)->pluck('id_kelurahan')->first();
        $query = Tkd::select(
            'tkds.id',
            'tkds.id_kelurahan',
            'tkds.bidang',
            'tkds.letak',
            'tkds.bukti',
            'tkds.harga_dasar',
            'tkds.luas',
            'tkds.keterangan',
            'tkds.nop',
            'kelurahans.kelurahan'
        )
            ->leftJoin('kelurahans', 'tkds.id_kelurahan', '=', 'kelurahans.id')
            ->when($request->input('letak'), function ($query, $letak) {
                return $query->where('tkds.letak', 'like', '%' . $letak . '%');
            })
            ->when($request->input('kelurahan'), function ($query, $kelurahan) {
                return $query->whereIn('tkds.id_kelurahan', $kelurahan);
            })
            ->where('tkds.id_kelurahan', $kelurahanIdFromDaerah)
            // ->orderBy('tkds.id_kelurahan', 'asc')
            ->paginate(20);
        $kelurahanSelected = $request->input('kelurahan');

        $query->appends(['tkd' => $tkdName, 'kelurahan' => $kelurahanIds]);

        return view('lelang.tkd.index')->with([
            'tkds' => $query,
            'kelurahans' => $kelurahans,
            'tkdName' => $tkdName,
            'kelurahanIds' => $kelurahanIds,
            'kelurahanSelected' => $kelurahanSelected,
            'tkd' => $tkd,
        ]);
    }

    public function create()
    {
        $kelurahanId = session('kelurahan_id');
        $kelurahans = Kelurahan::all();
        return view('lelang.tkd.create')->with([
            'kelurahans' => $kelurahans,
            'kelurahanId' => $kelurahanId,
        ]);
    }

    public function store(StoreTkdRequest $request)
    {
        $id_kelurahan = $request->id_kelurahan;
        $count = Tkd::where('id_kelurahan', $id_kelurahan)->count();
        $id_tkd = $id_kelurahan . "S" . ($count + 1);

        Tkd::create([
            'id_tkd' => $id_tkd,
            'id_kelurahan' => $id_kelurahan,
            'bidang' => $request->bidang,
            'letak' => $request->letak,
            'bukti' => $request->bukti,
            'harga_dasar' => $request->harga_dasar,
            'luas' => $request->luas,
            'keterangan' => $request->keterangan,
            'nop' => $request->nop,
        ]);

        return redirect()->route('tkd.index')->with('success', 'Tambah Data TKD Sukses');
    }

    public function show(Tkd $tkd)
    {
        return view('lelang.tkd.show', compact('tkd'));
    }

    public function edit(Tkd $tkd)
    {
        $kelurahans = Kelurahan::all();
        return view('lelang.tkd.edit', compact('tkd'))->with(['kelurahans' => $kelurahans]);
    }

    public function update(UpdateTkdRequest $request, Tkd $tkd)
    {
        $tkd->update($request->validated());
        return redirect()->route('tkd.index')->with('success', 'Tkd updated successfully.');
    }

    public function destroy(Tkd $tkd)
    {
        $tkd->delete();
        return redirect()->route('tkd.index')->with('success', 'Tkd deleted successfully.');
    }

    public function import(ImportTkdRequest $request)
    {
        Excel::import(new TkdsImport, $request->file('import-file')->store('import-files'));
        return redirect()->route('tkd.index')->with('success', 'Tambahkan Data TKD Sukses diimport');
    }

    public function export()
    {
        return Excel::download(new TkdsExport, 'TKD - Harga Dasar.xlsx');
    }

    public function downloadTemplate()
    {
        $templatePath = public_path('Excel/templates/tkd_template.xlsx');
        if (!file_exists($templatePath)) {
            return redirect()->route('tkd.index')->with('error', 'Template file not found.');
        }

        return response()->download($templatePath, 'tkd_template.xlsx');
    }
}
