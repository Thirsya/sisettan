<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::insert(
            [
                [
                    'id_user' => '1',
                    'id_pejabat' => null,
                    'hk' => '9'
                ],
                [
                    'id_user' => '2',
                    'id_pejabat' => '1',
                    'hk' => '1'
                ],
                [
                    'id_user' => '3',
                    'id_pejabat' => '2',
                    'hk' => '2'
                ],
                [
                    'id_user' => '4',
                    'id_pejabat' => null,
                    'hk' => '3'
                ],
                [
                    'id_user' => '5',
                    'id_pejabat' => null,
                    'hk' => '0'
                ],
            ]
        );
    }
}
