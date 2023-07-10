<?php

namespace Database\Seeders;

use App\Models\Tahun;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tahun::insert(
            [
                [
                    'tahun' => '2019'
                ],
                [
                    'tahun' => '2020'
                ],
                [
                    'tahun' => '2021'
                ],
                [
                    'tahun' => '2022'
                ],
            ]
        );
    }
}
