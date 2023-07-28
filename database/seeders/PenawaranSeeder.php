<?php

namespace Database\Seeders;

use App\Models\Penawaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenawaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Penawaran::insert(
            [
                [
                    'total_luas' => '6216',
                    'id_daftar' => '1',
                    'id_tkd' => '1',
                    'nilai_penawaran' => '65',
                    'keterangan' => 'aa',
                ],
                [
                    'total_luas' => '1000',
                    'id_daftar' => '3',
                    'id_tkd' => '3',
                    'nilai_penawaran' => '55',
                    'keterangan' => 'bismillah',
                ],
            ]
        );
    }
}
