<?php

namespace App\Http\Controllers;

use App\Models\Gugur;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGugurRequest;
use App\Http\Requests\UpdateGugurRequest;
use App\Models\Penawaran;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\DB;

class GugurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:gugur.index')->only('index');
        $this->middleware('permission:gugur.create')->only('create', 'store');
        $this->middleware('permission:gugur.edit')->only('edit', 'update');
        $this->middleware('permission:gugur.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $penawarans = Penawaran::all();
        $id_penawaran = $request->input('id_penawaran');
        $gugurs = DB::table('gugurs')
            ->select(
                'gugurs.id',
                'gugurs.id_penawaran',
                'gugurs.id_daftar',
                'gugurs.id_tkd',
                'gugurs.nilai_penawaran',
                'gugurs.keterangan',
                'penawarans.id_daftar',
                'penawarans.idfk_daftar',
                'penawarans.id_tkd',
                'penawarans.idfk_tkd',
                'penawarans.nilai_penawaran',
                'penawarans.keterangan',
                'penawarans.total_luas',
                'daftars.id_daftar',
                'daftars.no_urut',
                'daftars.nama',
                'daftars.alamat',
                'daftars.no_kk',
                'daftars.no_wp',
                'daftars.tgl_perjanjian',
                'tkds.id_tkd',
                'tkds.id_kelurahan',
                'tkds.bidang',
                'tkds.letak',
                'tkds.bukti',
                'tkds.harga_dasar',
                'tkds.luas',
                'tkds.keterangan',
                'tkds.nop',
            )
            ->leftJoin('penawarans', 'gugurs.id_penawaran', '=', 'penawarans.id')
            ->leftJoin('tkds', 'gugurs.id_tkd', '=', 'tkds.id')
            ->leftJoin('daftars', 'gugurs.id_daftar', '=', 'daftars.id')
            ->when($request->input('tkd'), function ($query, $tkd) {
                return $query->where('tkd', 'like', '%' . $tkd . '%');
            })
            ->when($request->input('penawaran'), function ($query, $penawaran) {
                return $query->whereIn('gugur.nilai_penawaran', $penawaran);
            })
            ->when($request->input('daftar'), function ($query, $daftar) {
                return $query->whereIn('gugur.nama', $daftar);
            })
            // ->orderBy('gugur.kode_jbs', 'asc')
            ->whereNull('gugurs.deleted_at')
            ->paginate(10);
        $penawaranSelected = $request->input('penawaran');
        return view('pdf.gugur.index')->with([
            'gugurs' => $gugurs,
            'penawarans' => $penawarans,
            'penawaranSelected' => $penawaranSelected,
            'id_penawaran' => $id_penawaran,
        ]);
    }

    public function cetakGugur()
    {
        $gugurs = Gugur::all();

        // view()->share('gugur', $gugur);
        $pdf = PDF::loadview('pdf.gugur.index', ['gugurs'=>$gugurs]);
        // return $pdf->download('Gugur PDF');
        return $pdf->stream();
    }

    public function create()
    {
        //
    }

    public function store(StoreGugurRequest $request)
    {
        //
    }

    public function show(Gugur $gugur)
    {
        //
    }

    public function edit(Gugur $gugur)
    {
        //
    }

    public function update(UpdateGugurRequest $request, Gugur $gugur)
    {
        //
    }

    public function destroy(Gugur $gugur)
    {
        //
    }
}
