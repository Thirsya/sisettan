<?php

namespace App\Imports;
use App\Models\Penawaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class PenawaransImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row)
    {
        return new Penawaran([
            'id_penawaran' => $row['id_penawaran'],
            'total_luas' => $row['total_luas'],
            'idfk_daftar' => $row['idfk_daftar'],
            'id_daftar' => $row['id_daftar'],
            'idfk_tkd' => $row['idfk_tkd'],
            'id_tkd' => $row['id_tkd'],
            'nilai_penawaran' => $row['nilai_penawaran'],
            'keterangan' => $row['keterangan'],
        ]);
    }

    public function uniqueBy()
    {
        return 'id_penawaran';
    }
}
