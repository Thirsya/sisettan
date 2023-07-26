<?php

namespace App\Imports;
use App\Models\Tkd;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class TkdsImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row)
    {
        return new Tkd([
            'bidang' => $row['bidang'],
            'letak' => $row['letak'],
            'id_kelurahan' => $row['kelurahan'],
            'bukti' => $row['bukti'],
            'harga_dasar' => $row['harga_dasar'],
            'luas' => $row['luas'],
            'keterangan' => $row['keterangan'],
            'nop' => $row['nop'],
        ]);
    }

    public function uniqueBy()
    {
        return 'harga_dasar';
    }
}
