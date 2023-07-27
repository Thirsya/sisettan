<?php

namespace Database\Seeders;

use App\Models\Daerah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaerahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Daerah::insert(
            [
                [
                    'id_kecamatan' => '3',
                    'id_kelurahan' => '27',
                    'noba' => '056',
                    'periode' => '1 Januari 2023 s/d 31 Desember 2024',
                    'thn_sts' => '4',
                    'tanggal_lelang' => '2022-12-27',
                ],
                [
                    'id_kecamatan' => '1',
                    'id_kelurahan' => '1',
                    'noba' => '25',
                    'periode' => '22 Oktober 2022 s/d 21 Oktober 2023',
                    'thn_sts' => '4',
                    'tanggal_lelang' => '2022-09-26',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '21',
                    'noba' => '6',
                    'periode' => '1 Nopember 2022 s/d 31 Oktober 2023',
                    'thn_sts' => '4',
                    'tanggal_lelang' => '2022-09-07',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '22',
                    'noba' => null,
                    'periode' => null,
                    'thn_sts' => null,
                    'tanggal_lelang' => null,
                ],
                [
                    'id_kecamatan' => '1',
                    'id_kelurahan' => '3',
                    'noba' => '26',
                    'periode' => '1 Januari 2023 s/d 31 Desember 2023',
                    'thn_sts' => '4',
                    'tanggal_lelang' => '2022-09-27',
                ],
                [
                    'id_kecamatan' => '3',
                    'id_kelurahan' => '28',
                    'noba' => '058',
                    'periode' => '1 Januari 2023 s/d 31 Desember 2024',
                    'thn_sts' => '4',
                    'tanggal_lelang' => '2022-12-27',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '19',
                    'noba' => '1',
                    'periode' => '1 Nopermber 2022 s/d 31 Oktober 2023',
                    'thn_sts' => '4',
                    'tanggal_lelang' => '2022-09-05',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '14',
                    'noba' => '3',
                    'periode' => '1 Nopermber 2022 s/d 31 Oktober 2023',
                    'thn_sts' => null,
                    'tanggal_lelang' => '2022-09-06',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '9',
                    'noba' => '15',
                    'periode' => '1 Januari 2023 s/d 31 Desember 2023',
                    'thn_sts' => null,
                    'tanggal_lelang' => '2022-09-14',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '13',
                    'noba' => '10',
                    'periode' => '1 Januari 2023 s/d 31 Desember 2023',
                    'thn_sts' => null,
                    'tanggal_lelang' => '2022-09-12',
                ],
            ]
        );
    }
}
