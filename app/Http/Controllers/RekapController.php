<?php

namespace App\Http\Controllers;

use App\Models\Penawaran;
use PDF;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    public function cetakRekap()
    {
        $rekaps = Penawaran::all();

        $pdf = PDF::loadview('pdf.rekap-sts.index', ['rekaps' => $rekaps]);
        return $pdf->stream();
    }
}
