<?php

namespace App\Exports;

use App\Models\Tkd;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TkdsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Tkd::Select('id_tkd', 'id_kelurahan', 'bidang', 'letak', 'bukti', 'harga_dasar', 'luas', 'keterangan', 'nop')->get();
    }

    public function headings(): array
    {
        return [
            'Id Tkd',
            'Kelurahan',
            'Bidang',
            'Letak',
            'Bukti',
            'Harga Dasar',
            'Luas',
            'Keterangan',
            'Nop'
        ];
    }
}
