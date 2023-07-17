<?php

namespace Database\Seeders;

use App\Models\Pejabat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PejabatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pejabat::insert(
            [
                [
                    'nama_pejabat' => 'ARIEF CHOLISUDIN Y,S.STP,MM',
                    'id_jabatan' => '1',
                    'nip_pejabat' => '19800727 199912 1 002',
                    'no_sk' => '119'
                ],
                [
                    'nama_pejabat' => 'WIDIOANTORO, S.Sos, M.Si',
                    'id_jabatan' => '1',
                    'nip_pejabat' => '19731205 199302 1 001',
                    'no_sk' => '119'
                ],
            ]
        );
    }
}
