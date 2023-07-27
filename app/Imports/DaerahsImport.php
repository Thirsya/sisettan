<?php

namespace App\Imports;

use App\Models\Daerah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class DaerahsImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row)
    {
        return new Daerah([
            'id_kecamatan' => $row['kecamatan'],
            'id_kelurahan' => $row['kelurahan'],
            'noba' => $row['noba'],
            'periode' => $row['periode'],
            'thn_sts' => $row['tahun_sts'],
            'tanggal_lelang' => $row['tanggal_lelang'],
        ]);
    }

    public function uniqueBy()
    {
        return 'periode';
    }
}

