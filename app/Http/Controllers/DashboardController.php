<?php

namespace App\Http\Controllers;

use App\Exports\DaftarsExport;
use App\Http\Requests\ImportDaftarRequest;
use App\Models\Daftar;
use App\Http\Requests\StoreDaftarRequest;
use App\Http\Requests\UpdateDaftarRequest;
use App\Imports\DaftarsImport;
use App\Models\Daerah;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Penawaran;
use App\Models\Profile;
use App\Models\Tahun;
use App\Models\Tkd;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $tahunSelected = session('selected_tahun_id');
        $tahunSelectedName = Tahun::where('id', $tahunSelected)->value('tahun');
        $daerahSelected = session('selected_kelurahan_id');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id_kelurahan', $daftarIdFromSession)
            ->whereYear('tanggal_lelang', $tahunSelectedName)
            ->pluck('id_kelurahan')->first();
        $totalPendaftar = Daftar::where('id_kelurahan', $kelurahanIdFromDaerah)->count();
        $tahun = Tahun::all();
        $kecamatans = Kecamatan::all();
        return view('home')->with([
            'kecamatans' => $kecamatans,
            'tahun' => $tahun,
            'tahunSelected' => $tahunSelected,
            'daerahSelected' => $daerahSelected,
            'totalPendaftar' => $totalPendaftar,
            'kelurahanIdFromDaerah' => $kelurahanIdFromDaerah,
        ]);
    }

    public function requestAjaxLogin(Request $request)
    {
        if ($request->ajax() && $request->has('tahun_id')) {
            $userId = Auth::user()->id;
            $user = Auth::user();
            $userKecamatan = Profile::where('id_user', $userId)->value('id_kecamatan');
            $tahunId = $request->input('tahun_id');
            $tahunName = Tahun::select('tahuns.id', 'tahuns.tahun')->where('id', $tahunId)->pluck('id')->first();

            $query = Kelurahan::select('kelurahans.id', 'kelurahans.kelurahan', 'daerahs.tanggal_lelang', 'daerahs.id_kecamatan', 'kecamatans.kecamatan')
                ->leftJoin('daerahs', function ($join) use ($tahunName) {
                    $join->on('kelurahans.id', '=', 'daerahs.id_kelurahan')
                        ->where('daerahs.thn_sts', $tahunName);
                })
                ->leftJoin('kecamatans', 'kelurahans.id_kecamatan', '=', 'kecamatans.id');

            if ($user->hasRole('user')) {
                $query->where('kelurahans.id_kecamatan', $userKecamatan);
            }

            $data = $query->get();

            return response()->json($data);
        }
    }


    public function storeSelectedValues(Request $request)
    {
        $selectedTahunId = $request->input('tahun_id');
        $selectedKelurahanId = $request->input('kelurahan_id');
        session(['selected_tahun_id' => $selectedTahunId, 'selected_kelurahan_id' => $selectedKelurahanId]);

        return response()->json(['message' => 'Selected values stored successfully']);
    }

    public function getTotalPendaftar()
    {
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::where('id', $selectedTahunId)->value('tahun');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id_kelurahan', $daftarIdFromSession)
            ->whereYear('tanggal_lelang', $tahunSelected)
            ->pluck('id_kelurahan')->first();
        $totalPendaftar = Daftar::where('id_kelurahan', $kelurahanIdFromDaerah)
            ->count();
        return response()->json(['totalPendaftar' => $totalPendaftar]);
    }

    public function getTotalPenawaran()
    {
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::where('id', $selectedTahunId)->value('tahun');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id_kelurahan', $daftarIdFromSession)
            ->whereYear('tanggal_lelang', $tahunSelected)
            ->pluck('id_kelurahan')->first();
        $totalPenawaran = Penawaran::leftJoin('daftars', 'penawarans.idfk_daftar', '=', 'daftars.id')
            ->where('daftars.id_kelurahan', $kelurahanIdFromDaerah)->count();
        return response()->json(['totalPenawaran' => $totalPenawaran]);
    }

    public function getTotalDaerah()
    {
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::where('id', $selectedTahunId)->value('tahun');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $totalDaerah = Daerah::where('id_kelurahan', $daftarIdFromSession)
            ->whereYear('tanggal_lelang', $tahunSelected)
            ->count();
        return response()->json(['totalDaerah' => $totalDaerah]);
    }

    public function getTotalTkd()
    {
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::where('id', $selectedTahunId)->value('tahun');
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahanIdFromDaerah = Daerah::where('id_kelurahan', $daftarIdFromSession)
            ->whereYear('tanggal_lelang', $tahunSelected)
            ->pluck('id_kelurahan')->first();
        $totalTkd = Tkd::where('id_kelurahan', $kelurahanIdFromDaerah)->count();
        return response()->json(['totalTkd' => $totalTkd]);
    }

    public function getKelurahansDashboard()
    {
        $selectedTahunId = session('selected_tahun_id');
        $tahunSelected = Tahun::select('id', 'tahun')->where('id', $selectedTahunId)->first();
        $daftarIdFromSession = (int) session('selected_kelurahan_id');
        $kelurahans = Kelurahan::select(
            'kelurahans.id',
            'kelurahans.id_kecamatan',
            'kelurahans.kelurahan',
            'kecamatans.kecamatan'
        )
            ->leftJoin('kecamatans', 'kelurahans.id_kecamatan', '=', 'kecamatans.id')
            ->where('kelurahans.id', $daftarIdFromSession)->first();
        return response()->json([
            'kelurahans' => $kelurahans,
            'tahunSelected' => $tahunSelected
        ]);
    }
}
