<?php

namespace App\Imports;
use App\Models\Daftar;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class DaftarsImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row)
    {
        return new Daftar([
            'no_urut' => $row['nomor_urut'],
            'nama' => $row['nama'],
            'id_kelurahan' => $row['kelurahan'],
            'alamat' => $row['alamat'],
            'no_kk' => $row['nomor_kk'],
            'no_wp' => $row['nomor_wp'],
            'tgl_perjanjian' => $row['tanggal_perjanjian'],
        ]);
    }

    public function uniqueBy()
    {
        return 'nomor_kk';
    }
}
