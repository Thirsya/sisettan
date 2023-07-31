<?php

namespace Database\Seeders;

use App\Models\Daftar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaftarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Daftar::insert(
            [
                [
                    'id_daftar' => '8P1',
                    'id_kelurahan' => '8',
                    'no_urut' => '1',
                    'nama' => 'MOCH. YASJID',
                    'alamat' => 'JAMSAREN RT 039 RW 09',
                    'no_kk' => '3571031605060817',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-30'
                ],
                [
                    'id_daftar' => '8P2',
                    'id_kelurahan' => '8',
                    'no_urut' => '2',
                    'nama' => 'ROHADI',
                    'alamat' => 'JAMSAREN RT 039 RW 09',
                    'no_kk' => '3571031605060811',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-30'
                ],
                [
                    'id_daftar' => '8P3',
                    'id_kelurahan' => '8',
                    'no_urut' => '3',
                    'nama' => 'SUGITO',
                    'alamat' => 'JAMSAREN RT 039 RW 09',
                    'no_kk' => '3571031605060812',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-30'
                ],
                [
                    'id_daftar' => '8P4',
                    'id_kelurahan' => '8',
                    'no_urut' => '4',
                    'nama' => 'MUJIB',
                    'alamat' => 'JAMSAREN RT 029 RW 06',
                    'no_kk' => '3571031605061951',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-10-13'
                ],
                [
                    'id_daftar' => '8P5',
                    'id_kelurahan' => '8',
                    'no_urut' => '5',
                    'nama' => 'HERI SURYANTO',
                    'alamat' => 'JAMSAREN RT 035 RW 08',
                    'no_kk' => '3571031102170006',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-07'
                ],
                [
                    'id_kelurahan' => '9',
                    'no_urut' => '1',
                    'nama' => 'SLAMET ROCHANI',
                    'alamat' => 'LINGKUNGAN GROGOL RT 40 RW 09',
                    'no_kk' => '3571030405070026',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-16'
                ],
                [
                    'id_kelurahan' => '9',
                    'no_urut' => '2',
                    'nama' => 'SAMSU HADI',
                    'alamat' => 'LINGKUNGAN GROGOL RT 39 RW 08',
                    'no_kk' => '3571031605063157',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-29'
                ],
                [
                    'id_kelurahan' => '9',
                    'no_urut' => '3',
                    'nama' => 'BONADI',
                    'alamat' => 'LINGKUNGAN GROGOL RT 40 RW 09',
                    'no_kk' => '3571030405070016',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-29'
                ],
                [
                    'id_kelurahan' => '9',
                    'no_urut' => '4',
                    'nama' => 'SUROSO',
                    'alamat' => 'LINGKUNGAN GROGOL RT 41 RW 09',
                    'no_kk' => '3571031508070006',
                    'no_wp' => null,
                    'tgl_perjanjian' => null
                ],
                [
                    'id_kelurahan' => '9',
                    'no_urut' => '5',
                    'nama' => 'SUPIYAN',
                    'alamat' => 'LINGKUNGAN GROGOL RT 38 RW 08',
                    'no_kk' => '3571031605061926',
                    'no_wp' => null,
                    'tgl_perjanjian' => null
                ],
                [
                    'id_kelurahan' => '10',
                    'no_urut' => '1',
                    'nama' => 'ERVIN BAPTIAS PRATAMA',
                    'alamat' => 'TINALAN RT 01 RW 10',
                    'no_kk' => '3571030411170005',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-16'
                ],
                [
                    'id_kelurahan' => '10',
                    'no_urut' => '2',
                    'nama' => 'SRIATI`AH',
                    'alamat' => 'TINALAN RT 01 RW 10',
                    'no_kk' => '3571031405060264',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-16'
                ],
                [
                    'id_kelurahan' => '10',
                    'no_urut' => '3',
                    'nama' => 'SABARODIN',
                    'alamat' => 'TINALAN RT 01 RW 10',
                    'no_kk' => '3571030505070040',
                    'no_wp' => null,
                    'tgl_perjanjian' => null
                ],
                [
                    'id_kelurahan' => '10',
                    'no_urut' => '4',
                    'nama' => 'SAHLAN',
                    'alamat' => 'TINALAN RT 01 RW 10',
                    'no_kk' => '3571030505070034',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-16'
                ],
                [
                    'id_kelurahan' => '10',
                    'no_urut' => '5',
                    'nama' => 'SAMSUL ARIFIN',
                    'alamat' => 'TINALAN RT 02 RW 10',
                    'no_kk' => '3571032506080024',
                    'no_wp' => null,
                    'tgl_perjanjian' => null
                ],
                [
                    'id_kelurahan' => '11',
                    'no_urut' => '1',
                    'nama' => 'SUNARKO',
                    'alamat' => 'RT 30 RW 06',
                    'no_kk' => '3571030406100002',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-28'
                ],
                [
                    'id_kelurahan' => '11',
                    'no_urut' => '2',
                    'nama' => 'AGUS HERI SISWANTO',
                    'alamat' => 'RT 33 RW 06',
                    'no_kk' => '3571033006090006',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-28'
                ],
                [
                    'id_kelurahan' => '11',
                    'no_urut' => '3',
                    'nama' => 'IRIK WIBOWO',
                    'alamat' => 'RT 24 RW 05',
                    'no_kk' => '3571030206090010',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-28'
                ],
                [
                    'id_kelurahan' => '11',
                    'no_urut' => '4',
                    'nama' => 'EKO PURWOKO',
                    'alamat' => 'RT 33 RW 06',
                    'no_kk' => '3571032604070271',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-28'
                ],
                [
                    'id_kelurahan' => '11',
                    'no_urut' => '5',
                    'nama' => 'DAWUD',
                    'alamat' => 'RT 26 RW 05',
                    'no_kk' => '3571031311080008',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-28'
                ],
                [
                    'id_kelurahan' => '12',
                    'no_urut' => '1',
                    'nama' => 'MURTOMO',
                    'alamat' => 'RT 03 RW 03',
                    'no_kk' => '3571031509080012',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-23'
                ],
                [
                    'id_kelurahan' => '12',
                    'no_urut' => '2',
                    'nama' => 'SUARYANTO,SE',
                    'alamat' => 'RT 01 RW 03',
                    'no_kk' => '3571032607100005',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-23'
                ],
                [
                    'id_kelurahan' => '12',
                    'no_urut' => '3',
                    'nama' => 'DIDIK WAHYONO',
                    'alamat' => 'RT 06 RW 11',
                    'no_kk' => '3571032404070370',
                    'no_wp' => null,
                    'tgl_perjanjian' => '2022-09-21'
                ],
            ]
        );
    }
}
