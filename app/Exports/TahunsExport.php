<?php

namespace App\Exports;

use App\Models\Tahun;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TahunsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Tahun::Select('tahun')->get();
    }

    public function headings(): array
    {
        return [
            'Tahun',
        ];
    }
}
