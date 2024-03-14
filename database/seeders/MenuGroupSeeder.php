<?php

namespace Database\Seeders;

use App\Models\MenuGroup;
use Illuminate\Database\Seeder;

class MenuGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // MenuGroup::factory()->count(5)->create();
        MenuGroup::insert(
            [
                [
                    'name' => 'Dashboard',
                    'icon' => 'fas fa-tachometer-alt',
                    'permission_name' => 'dashboard',
                ],
                [
                    'name' => 'Users Management',
                    'icon' => 'fas fa-users',
                    'permission_name' => 'user.management',
                ],
                [
                    'name' => 'Role Management',
                    'icon' => 'fas fa-user-tag',
                    'permisison_name' => 'role.permission.management',
                ],
                [
                    'name' => 'Menu Management',
                    'icon' => 'fas fa-bars',
                    'permisison_name' => 'menu.management',
                ],
                [
                    'name' => 'Pejabat',
                    'icon' => 'fas fa-user-tag',
                    'permission_name' => 'user.management',
                ],
                [
                    'name' => 'Master Data',
                    'icon' => 'fas fa-bars',
                    'permisison_name' => 'master.data',
                ],
                [
                    'name' => 'Lelang',
                    'icon' => 'fas fa-dollar-sign',
                    'permisison_name' => 'lelang',
                ],
                [
                    'name' => 'PDF',
                    'icon' => 'far fa-file',
                    'permisison_name' => 'pdf',
                ],
                [
                    'name' => 'Maps',
                    'icon' => 'fas fa-map-marker-alt',
                    'permisison_name' => 'maps',
                ],
            ]
        );
    }
}
