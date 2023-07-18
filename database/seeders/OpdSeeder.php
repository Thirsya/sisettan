<?php

namespace Database\Seeders;

use App\Models\Opd;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Opd::insert(
            [
                [
                    'no_opd' => '419.500',
                    'nama_opd' => 'Kecamatan Kota'
                ],
                [
                    'no_opd' => '419.600',
                    'nama_opd' => 'Kecamatan Pesantren'
                ],
            ]
        );
    }
}
