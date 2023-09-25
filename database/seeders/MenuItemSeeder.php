<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // MenuItem::factory()->count(10)->create();
        MenuItem::insert(
            [
                [
                    'name' => 'Dashboard',
                    'route' => 'dashboard',
                    'permission_name' => 'dashboard',
                    'menu_group_id' => 1,
                ],
                [
                    'name' => 'User List',
                    'route' => 'user-management/user',
                    'permission_name' => 'user.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Role List',
                    'route' => 'role-and-permission/role',
                    'permission_name' => 'role.index',
                    'menu_group_id' => 3,
                ],
                [
                    'name' => 'Permission List',
                    'route' => 'role-and-permission/permission',
                    'permission_name' => 'permission.index',
                    'menu_group_id' => 3,
                ],
                [
                    'name' => 'Permission To Role',
                    'route' => 'role-and-permission/assign',
                    'permission_name' => 'assign.index',
                    'menu_group_id' => 3,
                ],
                [
                    'name' => 'User To Role',
                    'route' => 'role-and-permission/assign-user',
                    'permission_name' => 'assign.user.index',
                    'menu_group_id' => 3,
                ],
                [
                    'name' => 'Menu Group',
                    'route' => 'menu-management/menu-group',
                    'permission_name' => 'menu-group.index',
                    'menu_group_id' => 4,
                ],
                [
                    'name' => 'Menu Item',
                    'route' => 'menu-management/menu-item',
                    'permission_name' => 'menu-item.index',
                    'menu_group_id' => 4,
                ],
                [
                    'name' => 'Jabatan List',
                    'route' => 'user-management/jabatan',
                    'permission_name' => 'jabatan.index',
                    'menu_group_id' => 5,
                ],
                [
                    'name' => 'Pejabat List',
                    'route' => 'user-management/pejabat',
                    'permission_name' => 'pejabat.index',
                    'menu_group_id' => 5,
                ],
                [
                    'name' => 'OPD List',
                    'route' => 'user-management/opd',
                    'permission_name' => 'opd.index',
                    'menu_group_id' => 5,
                ],
                [
                    'name' => 'Tahun',
                    'route' => 'master-data/tahun',
                    'permission_name' => 'tahun.index',
                    'menu_group_id' => 6,
                ],
                [
                    'name' => 'Kecamatan',
                    'route' => 'master-data/kecamatan',
                    'permission_name' => 'kecamatan.index',
                    'menu_group_id' => 6,
                ],
                [
                    'name' => 'Kelurahan',
                    'route' => 'master-data/kelurahan',
                    'permission_name' => 'kelurahan.index',
                    'menu_group_id' => 6,
                ],
                [
                    'name' => 'Daerah Lelang',
                    'route' => 'master-data/daerah',
                    'permission_name' => 'daerah.index',
                    'menu_group_id' => 6,
                ],
                [
                    'name' => 'Pendaftar Lelang',
                    'route' => 'lelang/daftar',
                    'permission_name' => 'daftar.index',
                    'menu_group_id' => 7,
                ],
                [
                    'name' => 'Harga Dasar',
                    'route' => 'lelang/tkd',
                    'permission_name' => 'tkd.index',
                    'menu_group_id' => 7,
                ],

                [
                    'name' => 'Penawaran',
                    'route' => 'lelang/penawaran',
                    'permission_name' => 'penawaran.index',
                    'menu_group_id' => 7,
                ],
                [
                    'name' => 'Pemenang 1-5',
                    'route' => 'pdf/pemenang',
                    'permission_name' => 'pemenang.index',
                    'menu_group_id' => 8,
                ],
                [
                    'name' => 'Rekap STS',
                    'route' => 'pdf/rekap-sts',
                    'permission_name' => 'rekap-sts.index',
                    'menu_group_id' => 8,
                ],
                [
                    'name' => 'Gugur',
                    'route' => '/pdf/cetakgugur',
                    'permission_name' => 'gugur.index',
                    'menu_group_id' => 8,
                ],
            ]
        );
    }
}
