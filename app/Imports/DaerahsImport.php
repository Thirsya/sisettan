<?php

namespace App\Imports;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Daerah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class DaerahsImport implements ToModel, WithHeadingRow, WithUpserts
{
    protected $kecamatans;
    protected $kelurahans;

    public function __construct()
    {
        $this->kecamatans = Kecamatan::select('id', 'kecamatan')->get();
        $this->kelurahans = Kelurahan::select('id', 'kelurahan')->get();
    }

    public function model(array $row)
    {
        $kecamatan = $this->kecamatans->where('kecamatan', $row['kecamatan'])->first();
        $kelurahan = $this->kelurahans->where('kelurahan', $row['kelurahan'])->first();
        return new Daerah([
            'id_kecamatan' => $kecamatan->id ?? null,
            'id_kelurahan' => $kelurahan->id ?? null,
            'tanggal_lelang' => $row['tanggal_lelang'],
        ]);
    }

    public function headings(): array
    {
        return [
            'Kecamatan',
            'Kelurahan',
            'Tanggal Lelang',
        ];
    }

    public function uniqueBy()
    {
        return 'tanggal_lelang';
    }
}
