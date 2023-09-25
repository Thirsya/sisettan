<?php

namespace App\Http\Controllers;

use App\Models\Penawaran;
use PDF;
use Illuminate\Support\Facades\DB;

class PemenangController extends Controller
{
    public function cetakPemenang()
    {
        $pemenangs = Penawaran::all();

        $pdf = PDF::loadview('pdf.pemenang.index', ['pemenangs' => $pemenangs]);
        return $pdf->stream();
    }
}
