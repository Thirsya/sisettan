<?php

namespace Database\Seeders;

use App\Models\Tkd;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TkdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tkd::insert(
            [
                [
                    'id_kelurahan' => '13',
                    'bidang' => '1',
                    'letak' => 'Kel Jamsaren',
                    'bukti' => 'SHP 58',
                    'harga_dasar' => '1645000',
                    'luas' => '1225',
                    'keterangan' => null,
                    'nop' => null,
                ],
                [
                    'id_kelurahan' => '13',
                    'bidang' => '2',
                    'letak' => 'Kel Jamsaren',
                    'bukti' => 'SHP 52',
                    'harga_dasar' => '2027300',
                    'luas' => '1514',
                    'keterangan' => null,
                    'nop' => null,
                ],
                [
                    'id_kelurahan' => '13',
                    'bidang' => '1',
                    'letak' => 'Kel Jamsaren',
                    'bukti' => 'SHP 51',
                    'harga_dasar' => '2027533',
                    'luas' => '1514',
                    'keterangan' => null,
                    'nop' => null,
                ],
                [
                    'id_kelurahan' => '13',
                    'bidang' => '2',
                    'letak' => 'Kel Jamsaren',
                    'bukti' => 'SHP 51',
                    'harga_dasar' => '2027533',
                    'luas' => '1514',
                    'keterangan' => null,
                    'nop' => null,
                ],
                [
                    'id_kelurahan' => '13',
                    'bidang' => '3',
                    'letak' => 'Kel Jamsaren',
                    'bukti' => 'SHP 51',
                    'harga_dasar' => '2027533',
                    'luas' => '1514',
                    'keterangan' => null,
                    'nop' => null,
                ],
                [
                    'id_kelurahan' => '14',
                    'bidang' => '1',
                    'letak' => 'Tempurejo',
                    'bukti' => 'SHP 7',
                    'harga_dasar' => '3767000',
                    'luas' => '3060',
                    'keterangan' => 'Lor omah Kwangkalan',
                    'nop' => null,
                ],
                [
                    'id_kelurahan' => '14',
                    'bidang' => '1',
                    'letak' => 'Blabak',
                    'bukti' => 'SHP 6',
                    'harga_dasar' => '1839500',
                    'luas' => '1485',
                    'keterangan' => null,
                    'nop' => null,
                ],
                [
                    'id_kelurahan' => '14',
                    'bidang' => '1',
                    'letak' => 'Blabak',
                    'bukti' => 'SHP 7',
                    'harga_dasar' => '5004500',
                    'luas' => '3935',
                    'keterangan' => 'Lor omah Pagut',
                    'nop' => null,
                ],
                [
                    'id_kelurahan' => '15',
                    'bidang' => '1',
                    'letak' => 'Kidul Omah',
                    'bukti' => 'SHP 6',
                    'harga_dasar' => '2620500',
                    'luas' => '1940',
                    'keterangan' => 'Jl. Raya Bawang - Betet',
                    'nop' => null,
                ],
                [
                    'id_kelurahan' => '15',
                    'bidang' => '1',
                    'letak' => 'Kel. Tinalan',
                    'bukti' => 'Seb. SHP 13 dan 14',
                    'harga_dasar' => '3750000',
                    'luas' => '2800',
                    'keterangan' => 'Sebagian sisa lapangan',
                    'nop' => null,
                ],
                [
                    'id_kelurahan' => '15',
                    'bidang' => '1',
                    'letak' => 'Belakang Gedung',
                    'bukti' => 'Seb. SHP 16',
                    'harga_dasar' => '18000000',
                    'luas' => '8570',
                    'keterangan' => null,
                    'nop' => null,
                ],
                [
                    'id_kelurahan' => '16',
                    'bidang' => '1',
                    'letak' => 'Jambu/pagu',
                    'bukti' => 'SHP 3',
                    'harga_dasar' => '7975000',
                    'luas' => '5530',
                    'keterangan' => null,
                    'nop' => null,
                ],
                [
                    'id_kelurahan' => '16',
                    'bidang' => '1',
                    'letak' => 'Gringging',
                    'bukti' => 'SHP 1',
                    'harga_dasar' => '27905000',
                    'luas' => '19015',
                    'keterangan' => null,
                    'nop' => null,
                ],
                [
                    'id_kelurahan' => '16',
                    'bidang' => '1',
                    'letak' => 'Bawang',
                    'bukti' => 'SHP 28',
                    'harga_dasar' => '5642850',
                    'luas' => '3880',
                    'keterangan' => 'Eks Mudin Jaenuri (sebagian tanah tidak produktif)',
                    'nop' => null,
                ],
            ]
        );
    }
}
