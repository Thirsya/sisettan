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
        $tanggalLelang = $row['tanggal_lelang'];

        if ($tanggalLelang === null) {
            $formattedDate = null;
        } else {
            $formattedDate = $this->parseExcelDate($tanggalLelang);
        }
        return new Daerah([
            'id_kecamatan' => $row['kecamatan'],
            'id_kelurahan' => $row['kelurahan'],
            'noba' => $row['noba'],
            'periode' => $row['periode'],
            'thn_sts' => $row['tahun_sts'],
            'tanggal_lelang' => $formattedDate
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
        return 'periode';
    }
}

