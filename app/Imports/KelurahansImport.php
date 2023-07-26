<?php

namespace App\Imports;
use App\Models\Kelurahan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class KelurahansImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row)
    {
        return new Kelurahan([
            'id_kecamatan' => $row['kecamatan'],
            'kelurahan' => $row['kelurahan'],
        ]);
    }

    public function uniqueBy()
    {
        return 'kelurahan';
    }
}
