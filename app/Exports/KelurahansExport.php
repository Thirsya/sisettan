<?php

namespace App\Exports;

use App\Models\Kelurahan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KelurahansExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Kelurahan::Select('id_kecamatan', 'kelurahan')->get();
    }

    public function headings(): array
    {
        return [
            'Kecamatan',
            'Kelurahan',
        ];
    }
}
