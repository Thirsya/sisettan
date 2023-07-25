<?php

namespace App\Exports;

use App\Models\Pejabat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PejabatsExport implements FromCollection,  WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return Pejabat::select('pejabats.nama_pejabat', 'jabatans.jabatan',  'opds.nama_opd', 'pejabats.nip_pejabat', 'pejabats.no_sk')
            ->join('jabatans', 'pejabats.id_jabatan', '=', 'jabatans.id')
            ->join('opds', 'pejabats.id_opd', '=', 'opds.id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Pejabat',
            'Jabatan',
            'Opd',
            'NIP',
            'No SK'
        ];
    }
}
