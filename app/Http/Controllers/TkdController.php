<?php

namespace App\Http\Controllers;

use App\Models\Tkd;
use App\Http\Requests\StoreTkdRequest;
use App\Http\Requests\UpdateTkdRequest;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $query = Tkd::select('tkds.id', 'tkds.id_kelurahan', 'tkds.bidang', 'tkds.letak', 'tkds.bukti',
        'tkds.harga_dasar', 'tkds.luas', 'tkds.keterangan', 'tkds.nop', 'kelurahans.kelurahan')
            ->leftJoin('kelurahans', 'tkds.id_kelurahan', '=', 'kelurahans.id')
            ->when($request->input('letak'), function ($query, $letak) {
                return $query->where('tkds.letak', 'like', '%' . $letak . '%');
            })
            ->when($request->input('kelurahan'), function ($query, $kelurahan) {
                return $query->whereIn('tkds.id_kelurahan', $kelurahan);
            })
            // ->orderBy('tkds.id_kelurahan', 'asc')
            ->paginate(10);
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
        $kelurahans = Kelurahan::all();
        return view('lelang.tkd.create')->with(['kelurahans' => $kelurahans]);
    }

    public function store(StoreTkdRequest $request)
    {
        Tkd::create($request->validated());
        return redirect()->route('tkd.index')->with('success', 'Tkd created successfully.');
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
}
