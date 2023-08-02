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
        $tanggalPerjanjian = $row['tanggal_perjanjian'];

        if ($tanggalPerjanjian === null) {
            $formattedDate = null;
        } else {
            $formattedDate = $this->parseExcelDate($tanggalPerjanjian);
        }
        return new Daftar([
            'id_daftar' => $row['id_daftar'],
            'no_urut' => $row['nomor_urut'],
            'nama' => $row['nama'],
            'id_kelurahan' => $row['kelurahan'],
            'alamat' => $row['alamat'],
            'no_kk' => $row['nomor_kk'],
            'no_wp' => $row['nomor_wp'],
            'tgl_perjanjian' => $formattedDate
        ]);
    }
    private function parseExcelDate($excelDate)
    {
        $timestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($excelDate);
        $formattedDate = date('Y-m-d', $timestamp);

        return $formattedDate;
    }


    public function uniqueBy()
    {
        return 'nomor_kk';
    }
}
