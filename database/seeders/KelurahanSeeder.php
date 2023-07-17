<?php

namespace Database\Seeders;

use App\Models\Kelurahan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kelurahan::insert(
            [
                [
                    'kelurahan' => 'Dandangan',
                    'id_kecamatan' => '1',
                ],
                [
                    'kelurahan' => 'Balowerti',
                    'id_kecamatan' => '1',
                ],
                [
                    'kelurahan' => 'Semampir',
                    'id_kecamatan' => '1',
                ],
                [
                    'kelurahan' => 'Ngadirejo',
                    'id_kecamatan' => '1',
                ],
                [
                    'kelurahan' => 'Kaliombo',
                    'id_kecamatan' => '1',
                ],
                [
                    'kelurahan' => 'Ngronggo',
                    'id_kecamatan' => '1',
                ],
                [
                    'kelurahan' => 'Banjaran',
                    'id_kecamatan' => '1',
                ],
                [
                    'kelurahan' => 'Jamsaren',
                    'id_kecamatan' => '2',
                ],
                [
                    'kelurahan' => 'Singonegaran',
                    'id_kecamatan' => '2',
                ],
                [
                    'kelurahan' => 'Tinalan',
                    'id_kecamatan' => '2',
                ],
                [
                    'kelurahan' => 'Pakunden',
                    'id_kecamatan' => '2',
                ],
                [
                    'kelurahan' => 'Burengan',
                    'id_kecamatan' => '2',
                ],
                [
                    'kelurahan' => 'Bangsal',
                    'id_kecamatan' => '2',
                ],
                [
                    'kelurahan' => 'Banaran',
                    'id_kecamatan' => '2',
                ],
                [
                    'kelurahan' => 'Tosaren',
                    'id_kecamatan' => '2',
                ],
                [
                    'kelurahan' => 'Ketami',
                    'id_kecamatan' => '2',
                ],
                [
                    'kelurahan' => 'Ngletih',
                    'id_kecamatan' => '2',
                ],
                [
                    'kelurahan' => 'Tempurejo',
                    'id_kecamatan' => '2',
                ],
                [
                    'kelurahan' => 'Betet',
                    'id_kecamatan' => '2',
                ],
                [
                    'kelurahan' => 'Bawang',
                    'id_kecamatan' => '2',
                ],
                [
                    'kelurahan' => 'Pesantren',
                    'id_kecamatan' => '2',
                ],
                [
                    'kelurahan' => 'Blabak',
                    'id_kecamatan' => '2',
                ],
                [
                    'kelurahan' => 'Dermo',
                    'id_kecamatan' => '3',
                ],
                [
                    'kelurahan' => 'Mrican',
                    'id_kecamatan' => '3',
                ],
                [
                    'kelurahan' => 'Ngampel',
                    'id_kecamatan' => '3',
                ],
                [
                    'kelurahan' => 'Gayam',
                    'id_kecamatan' => '3',
                ],
                [
                    'kelurahan' => 'Mojoroto',
                    'id_kecamatan' => '3',
                ],
                [
                    'kelurahan' => 'Pojok',
                    'id_kecamatan' => '3',
                ],
            ]
        );
    }
}
