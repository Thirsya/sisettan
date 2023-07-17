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
                    'id_kelurahan' => '26',
                    'tanggal_lelang' => '2022-12-27',
                ],
                [
                    'id_kecamatan' => '1',
                    'id_kelurahan' => '1',
                    'tanggal_lelang' => '2022-09-26',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '21',
                    'tanggal_lelang' => '2022-09-07',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '22',
                    'tanggal_lelang' => null,
                ],
                [
                    'id_kecamatan' => '1',
                    'id_kelurahan' => '3',
                    'tanggal_lelang' => '2022-09-27',
                ],
                [
                    'id_kecamatan' => '3',
                    'id_kelurahan' => '28',
                    'tanggal_lelang' => '2022-12-27',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '19',
                    'tanggal_lelang' => '2022-09-05',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '14',
                    'tanggal_lelang' => '2022-09-06',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '9',
                    'tanggal_lelang' => '2022-09-14',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '13',
                    'tanggal_lelang' => '2022-09-12',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '20',
                    'tanggal_lelang' => '2022-09-05',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '12',
                    'tanggal_lelang' => '2022-09-12',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '18',
                    'tanggal_lelang' => '2022-09-13',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '16',
                    'tanggal_lelang' => '2022-09-08',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '17',
                    'tanggal_lelang' => '2022-09-08',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '10',
                    'tanggal_lelang' => '2022-09-13',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '8',
                    'tanggal_lelang' => '2022-09-07',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '15',
                    'tanggal_lelang' => '2022-09-06',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '11',
                    'tanggal_lelang' => '2022-09-14',
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '21',
                    'tanggal_lelang' => null,
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '19',
                    'tanggal_lelang' => null,
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '10',
                    'tanggal_lelang' => null,
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '11',
                    'tanggal_lelang' => null,
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '14',
                    'tanggal_lelang' => null,
                ],
                [
                    'id_kecamatan' => '2',
                    'id_kelurahan' => '8',
                    'tanggal_lelang' => null,
                ],
            ]
        );
    }
}
