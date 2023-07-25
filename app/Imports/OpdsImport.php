<?php

namespace App\Imports;
use App\Models\Opd;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class OpdsImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row)
    {
        return new Opd([
            'no_opd' => $row['nomor_opd'],
            'nama_opd' => $row['nama_opd'],
        ]);
    }

    public function uniqueBy()
    {
        return 'no_opd';
    }
}
