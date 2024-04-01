<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use App\Models\Kelurahan;
use App\Models\Tahun;
use App\Models\Tkd;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index()
    {

        $kelurahans = Kelurahan::all();
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::where('id', $selectedTahunId)->value('tahun');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id_kelurahan', $daftarIdFromSession)
            ->whereYear('tanggal_lelang', $tahunSelected)
            ->pluck('id_kelurahan')->first();

        $tkd = Tkd::select(
            'tkds.id',
            'tkds.id_kelurahan',
            'tkds.bidang',
            'tkds.letak',
            'tkds.bukti',
            'tkds.harga_dasar',
            'tkds.luas',
            'tkds.keterangan',
            'tkds.nop',
            'tkds.longitude',
            'tkds.latitude',
            'tkds.foto',
            'kelurahans.kelurahan'
        )
            ->leftJoin('kelurahans', 'tkds.id_kelurahan', '=', 'kelurahans.id')
            ->where('tkds.id_kelurahan', $kelurahanIdFromDaerah)
            ->whereNull('tkds.deleted_at')
            ->get();


        return view('maps.detail.index')
            ->with([
                'tkd' => $tkd,
                'kelurahans' => $kelurahans,
            ]);
    }

    public function detail($id)
    {
        $tkd = Tkd::select(
            'tkds.id',
            'tkds.id_kelurahan',
            'tkds.bidang',
            'tkds.letak',
            'tkds.bukti',
            'tkds.harga_dasar',
            'tkds.luas',
            'tkds.keterangan',
            'tkds.nop',
            'tkds.longitude',
            'tkds.latitude',
            'tkds.latitude',
            'tkds.foto',
            'kelurahans.kelurahan',
            'kecamatans.kecamatan'
        )
            ->leftJoin('kelurahans', 'tkds.id_kelurahan', '=', 'kelurahans.id')
            ->leftJoin('kecamatans', 'kelurahans.id_kecamatan', '=', 'kecamatans.id')
            ->where('tkds.id', $id)
            ->first();
        return response()->json($tkd, 200);
    }
}
