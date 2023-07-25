<?php

namespace App\Exports;

use App\Models\Opd;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OpdsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Opd::Select('no_opd','nama_opd')->get();
    }

    public function headings(): array
    {
        return [
            'Nomor OPD',
            'Nama OPD'
        ];
    }
}
