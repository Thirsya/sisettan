<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use App\Models\Daftar;
use App\Models\Penawaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class StsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id', $daftarIdFromSession)->pluck('id_kelurahan')->first();
        $penawaran = Penawaran::select(
            DB::raw('penawarans.idfk_tkd, MAX(penawarans.nilai_penawaran) as nilai_penawaran'),
            'daftars.no_urut',
            'daftars.nama',
            'daftars.tgl_perjanjian',
            'tkds.bukti',
            'tkds.bidang',
            'tkds.luas',
            'penawarans.id'
        )
            ->leftJoin('tkds', 'tkds.id', 'penawarans.idfk_tkd')
            ->leftJoin('daftars', 'daftars.id', 'penawarans.idfk_daftar')
            ->groupBy('id', 'idfk_tkd', 'no_urut', 'nama', 'tgl_perjanjian', 'bukti', 'luas', 'bidang')
            ->where('daftars.id_kelurahan', $kelurahanIdFromDaerah)
            ->whereNull('penawarans.deleted_at')
            ->where('penawarans.gugur', '=', false)
            ->get();
        return view('lelang.penawaran.sts', compact('penawaran'));
    }

    public function gugur(Request $request, $id)
    {
        $penawaran = Penawaran::find($id);
        if (!$penawaran) {
            return response()->json(['message' => 'Penawaran not found!'], 404);
        }
        $penawaran->gugur = true;
        $penawaran->save();

        return response()->json(['message' => 'Successfully updated!']);
    }

    public function updateDate(Penawaran $penawaran, Request $request)
    {
        if (!$penawaran) {
            return response()->json(['message' => 'Penawaran not found!'], 404);
        }

        $daftar = Daftar::find($penawaran->idfk_daftar);

        if (!$daftar) {
            return response()->json(['message' => 'Daftar not found!'], 404);
        }

        $daftar->tgl_perjanjian = $request->tgl_perjanjian;
        $daftar->save();

        return response()->json(['message' => 'Date updated successfully']);
    }

    public function printSTS($id)
    {
        $penawaran = Penawaran::find($id);

        if (!$penawaran) {
            return abort(404, 'Penawaran not found');
        }

        $pdf = PDF::loadView('lelang.penawaran.cetak-sts', ['penawaran' => $penawaran]);
        return $pdf->stream('sts-' . $id . '.pdf');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
