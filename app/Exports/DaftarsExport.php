<?php

namespace App\Exports;

use App\Models\Daftar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DaftarsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Daftar::Select('id_daftar','no_urut', 'nama', 'id_kelurahan', 'alamat', 'no_kk', 'no_wp', 'tgl_perjanjian')->get();
    }

    public function headings(): array
    {
        return [
            'Id Daftar',
            'Nomor Urut',
            'Nama',
            'Kelurahan',
            'Alamat',
            'Nomor KK',
            'Nomor WP',
            'Tanggal Perjanjian',
        ];
    }
}
