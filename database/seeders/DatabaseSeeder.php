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
            UserSeeder::class,
            RoleAndPermissionSeeder::class,
            MenuGroupSeeder::class,
            MenuItemSeeder::class,
            CategorySeeder::class,
            TahunSeeder::class,
            KecamatanSeeder::class,
            KelurahanSeeder::class,
            JabatanSeeder::class,
            OpdSeeder::class,
            // PejabatSeeder::class,
            DaerahSeeder::class,
            DaftarSeeder::class,
            TkdSeeder::class,
            PenawaranSeeder::class,
        ]);
    }
}
