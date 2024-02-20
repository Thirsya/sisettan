<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'dashboard']);
        Permission::create(['name' => 'user.management']);
        Permission::create(['name' => 'role.permission.management']);
        Permission::create(['name' => 'menu.management']);
        Permission::create(['name' => 'master.data']);
        Permission::create(['name' => 'lelang']);
        Permission::create(['name' => 'pdf']);
        Permission::create(['name' => 'maps']);

        //user
        Permission::create(['name' => 'user.index']);
        Permission::create(['name' => 'user.create']);
        Permission::create(['name' => 'user.edit']);
        Permission::create(['name' => 'user.destroy']);
        Permission::create(['name' => 'user.import']);
        Permission::create(['name' => 'user.export']);

        //role
        Permission::create(['name' => 'role.index']);
        Permission::create(['name' => 'role.create']);
        Permission::create(['name' => 'role.edit']);
        Permission::create(['name' => 'role.destroy']);
        Permission::create(['name' => 'role.import']);
        Permission::create(['name' => 'role.export']);

        //permission
        Permission::create(['name' => 'permission.index']);
        Permission::create(['name' => 'permission.create']);
        Permission::create(['name' => 'permission.edit']);
        Permission::create(['name' => 'permission.destroy']);
        Permission::create(['name' => 'permission.import']);
        Permission::create(['name' => 'permission.export']);

        //assignpermission
        Permission::create(['name' => 'assign.index']);
        Permission::create(['name' => 'assign.create']);
        Permission::create(['name' => 'assign.edit']);
        Permission::create(['name' => 'assign.destroy']);

        //assingusertorole
        Permission::create(['name' => 'assign.user.index']);
        Permission::create(['name' => 'assign.user.create']);
        Permission::create(['name' => 'assign.user.edit']);

        //menu group
        Permission::create(['name' => 'menu-group.index']);
        Permission::create(['name' => 'menu-group.create']);
        Permission::create(['name' => 'menu-group.edit']);
        Permission::create(['name' => 'menu-group.destroy']);

        //menu item
        Permission::create(['name' => 'menu-item.index']);
        Permission::create(['name' => 'menu-item.create']);
        Permission::create(['name' => 'menu-item.edit']);
        Permission::create(['name' => 'menu-item.destroy']);

        Permission::create(['name' => 'tahun.index']);
        Permission::create(['name' => 'tahun.create']);
        Permission::create(['name' => 'tahun.edit']);
        Permission::create(['name' => 'tahun.destroy']);

        Permission::create(['name' => 'kecamatan.index']);
        Permission::create(['name' => 'kecamatan.create']);
        Permission::create(['name' => 'kecamatan.edit']);
        Permission::create(['name' => 'kecamatan.destroy']);

        Permission::create(['name' => 'kelurahan.index']);
        Permission::create(['name' => 'kelurahan.create']);
        Permission::create(['name' => 'kelurahan.edit']);
        Permission::create(['name' => 'kelurahan.destroy']);

        Permission::create(['name' => 'daerah.index']);
        Permission::create(['name' => 'daerah.create']);
        Permission::create(['name' => 'daerah.edit']);
        Permission::create(['name' => 'daerah.destroy']);

        Permission::create(['name' => 'jabatan.index']);
        Permission::create(['name' => 'jabatan.create']);
        Permission::create(['name' => 'jabatan.edit']);
        Permission::create(['name' => 'jabatan.destroy']);

        Permission::create(['name' => 'pejabat.index']);
        Permission::create(['name' => 'pejabat.create']);
        Permission::create(['name' => 'pejabat.edit']);
        Permission::create(['name' => 'pejabat.destroy']);

        Permission::create(['name' => 'opd.index']);
        Permission::create(['name' => 'opd.create']);
        Permission::create(['name' => 'opd.edit']);
        Permission::create(['name' => 'opd.destroy']);

        Permission::create(['name' => 'daftar.index']);
        Permission::create(['name' => 'daftar.create']);
        Permission::create(['name' => 'daftar.edit']);
        Permission::create(['name' => 'daftar.destroy']);

        Permission::create(['name' => 'tkd.index']);
        Permission::create(['name' => 'tkd.create']);
        Permission::create(['name' => 'tkd.edit']);
        Permission::create(['name' => 'tkd.destroy']);

        Permission::create(['name' => 'penawaran.index']);
        Permission::create(['name' => 'penawaran.create']);
        Permission::create(['name' => 'penawaran.edit']);
        Permission::create(['name' => 'penawaran.destroy']);

        Permission::create(['name' => 'pemenang.index']);
        // Permission::create(['name' => 'pemenang.create']);
        // Permission::create(['name' => 'pemenang.edit']);
        // Permission::create(['name' => 'pemenang.destroy']);

        Permission::create(['name' => 'rekap-sts.index']);
        // Permission::create(['name' => 'rekap-sts.create']);
        // Permission::create(['name' => 'rekap-sts.edit']);
        // Permission::create(['name' => 'rekap-sts.destroy']);

        Permission::create(['name' => 'gugur.index']);
        // Permission::create(['name' => 'gugur.create']);
        // Permission::create(['name' => 'gugur.edit']);
        // Permission::create(['name' => 'gugur.destroy']);

        Permission::create(['name' => 'detail.index']);

        // create roles
        $roleUser = Role::create(['name' => 'user']);
        $roleUser->givePermissionTo([
            'dashboard',
            'master.data',
            'lelang',
            'pdf',
            'maps',
            'daftar.index',
            'daftar.create',
            'daftar.edit',
            'daftar.destroy',
            'tkd.index',
            'tkd.create',
            'tkd.edit',
            'tkd.destroy',
            'penawaran.index',
            'penawaran.create',
            'penawaran.edit',
            'penawaran.destroy',
            'daerah.index',
            'daerah.create',
            'daerah.edit',
            'daerah.destroy',
            'pemenang.index',
            'rekap-sts.index',
            'gugur.index',
            'detail.index',
        ]);

        // create Super Admin
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        //assign user id 1 ke super admin
        $user = User::find(1);
        $user->assignRole('super-admin');
        $user = User::find(2);
        $user->assignRole('user');
    }
}
