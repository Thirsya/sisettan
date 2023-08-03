<?php

namespace App\Exports;

use App\Models\Penawaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PenawaransExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Penawaran::Select('id_penawaran', 'total_luas',
        'idfk_daftar', 'id_daftar',
        'idfk_tkd', 'id_tkd',
        'nilai_penawaran', 'keterangan')->get();
    }

    public function headings(): array
    {
        return [
            'Id Penawaran',
            'Total Luas',
            'Id FK Daftar',
            'Id Daftar',
            'Id FK TKD',
            'Id TKD',
            'Nilai Penawaran',
            'Keterangan',
        ];
    }
}
