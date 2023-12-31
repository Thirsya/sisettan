<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
                // \App\Models\User::factory(10)->create();
        $this->call([
            MenuGroupSeeder::class,
            MenuItemSeeder::class,
            CategorySeeder::class,
            TahunSeeder::class,
            KecamatanSeeder::class,
            JabatanSeeder::class,
            OpdSeeder::class,
            PejabatSeeder::class,
            UserSeeder::class,
            RoleAndPermissionSeeder::class,
            ProfileSeeder::class,
            // KelurahanSeeder::class,
            // DaerahSeeder::class,
            // DaftarSeeder::class,
            // TkdSeeder::class,
            // PenawaranSeeder::class,
        ]);
    }
}
