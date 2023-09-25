<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreGugurRequest;
use App\Http\Requests\UpdateGugurRequest;
use App\Models\Penawaran;
use PDF;
use Illuminate\Support\Facades\DB;

class GugurController extends Controller
{

    public function cetakGugur()
    {
        $gugurs = Penawaran::all();

        // view()->share('gugur', $gugur);
        $pdf = PDF::loadview('pdf.gugur.index', ['gugurs'=>$gugurs]);
        // return $pdf->download('Gugur PDF');
        return $pdf->stream('Gugur');
    }
}
