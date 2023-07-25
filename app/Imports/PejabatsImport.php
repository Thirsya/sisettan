<?php

namespace App\Imports;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Jabatan;
use App\Models\Opd;
use App\Models\Pejabat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class PejabatsImport implements ToModel, WithHeadingRow, WithUpserts
{
    protected $jabatans;
    protected $opds;

    public function __construct()
    {
        $this->jabatans = Jabatan::select('id', 'jabatan')->get();
        $this->opds = Opd::select('id', 'no_opd', 'nama_opd')->get();
    }

    public function model(array $row)
    {
        $jabatan = $this->jabatans->where('jabatan', $row['jabatan'])->first();
        $opd = $this->opds->where('nama_opd', $row['opd'])->first();
        $opd = $this->opds->where('no_opd', $row['no_opd'])->first();
        return new Pejabat([
            'id_jabatan' => $jabatan->id ?? null,
            'id_opd' => $opd->id ?? null,
            'nama_pejabat' => $row['nama_pejabat'],
            'nip_pejabat' => $row['nip'],
            'no_sk' => $row['no_sk'],
        ]);
    }

    public function headings(): array
    {
        return [
            'Jabatan',
            'Opd',
            'Nama Pejabat',
            'NIP',
            'No SK',
        ];
    }

    public function uniqueBy()
    {
        return 'nip';
    }
}
