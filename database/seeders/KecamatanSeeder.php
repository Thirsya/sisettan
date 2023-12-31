<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kecamatan::insert(
            [
                [
                    'kecamatan' => 'Kota'
                ],
                [
                    'kecamatan' => 'Pesantren'
                ],
                [
                    'kecamatan' => 'Mojoroto'
                ],
            ]
        );
    }
}
