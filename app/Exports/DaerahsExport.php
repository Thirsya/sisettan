<?php

namespace App\Exports;

use App\Models\Daerah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DaerahsExport implements FromCollection,  WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return Daerah::select('kecamatans.kecamatan', 'kelurahans.kelurahan', 'daerahs.noba', 'daerahs.periode', 'tahuns.tahun',  'daerahs.tanggal_lelang')
            ->join('kecamatans', 'daerahs.id_kecamatan', '=', 'kecamatans.id')
            ->join('kelurahans', 'daerahs.id_kelurahan', '=', 'kelurahans.id')
            ->join('tahuns', 'daerahs.thn_sts', '=', 'tahuns.id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Kecamatan',
            'Kelurahan',
            'Noba',
            'Periode',
            'Tahun Sts',
            'Tanggal Lelang',
        ];
    }
}
