<?php

use App\Http\Controllers\DaerahController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\Menu\MenuGroupController;
use App\Http\Controllers\Menu\MenuItemController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\PejabatController;
use App\Http\Controllers\PenawaranController;
use App\Http\Controllers\RoleAndPermission\AssignPermissionController;
use App\Http\Controllers\RoleAndPermission\AssignUserToRoleController;
use App\Http\Controllers\RoleAndPermission\ExportPermissionController;
use App\Http\Controllers\RoleAndPermission\ExportRoleController;
use App\Http\Controllers\RoleAndPermission\ImportPermissionController;
use App\Http\Controllers\RoleAndPermission\ImportRoleController;
use App\Http\Controllers\RoleAndPermission\PermissionController;
use App\Http\Controllers\RoleAndPermission\RoleController;
use App\Http\Controllers\TahunController;
use App\Http\Controllers\TkdController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Models\Category;


Route::get('/', function () {
    return view('auth/login');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', function () {
        return view('home', ['users' => User::get(),]);
    });

    Route::prefix('user-management')->group(function () {
        Route::resource('user', UserController::class);
        Route::post('import', [UserController::class, 'import'])->name('user.import');
        Route::get('export', [UserController::class, 'export'])->name('user.export');
        Route::get('demo', DemoController::class)->name('user.demo');

        Route::post('jabatan/import', [JabatanController::class, 'import'])->name('jabatan.import');
        Route::get('jabatan/export', [JabatanController::class, 'export'])->name('jabatan.export');
        Route::resource('jabatan', JabatanController::class);

        Route::resource('pejabat', PejabatController::class);

        Route::post('opd/import', [OpdController::class, 'import'])->name('opd.import');
        Route::get('opd/export', [OpdController::class, 'export'])->name('opd.export');
        Route::resource('opd', OpdController::class);
    });

    Route::prefix('menu-management')->group(function () {
        Route::resource('menu-group', MenuGroupController::class);
        Route::resource('menu-item', MenuItemController::class);
    });
    Route::group(['prefix' => 'role-and-permission'], function () {
        //role
        Route::resource('role', RoleController::class);
        Route::get('role/export', ExportRoleController::class)->name('role.export');
        Route::post('role/import', ImportRoleController::class)->name('role.import');

        //permission
        Route::resource('permission', PermissionController::class);
        Route::get('permission/export', ExportPermissionController::class)->name('permission.export');
        Route::post('permission/import', ImportPermissionController::class)->name('permission.import');

        //assign permission
        Route::get('assign', [AssignPermissionController::class, 'index'])->name('assign.index');
        Route::get('assign/create', [AssignPermissionController::class, 'create'])->name('assign.create');
        Route::get('assign/{role}/edit', [AssignPermissionController::class, 'edit'])->name('assign.edit');
        Route::put('assign/{role}', [AssignPermissionController::class, 'update'])->name('assign.update');
        Route::post('assign', [AssignPermissionController::class, 'store'])->name('assign.store');

        //assign user to role
        Route::get('assign-user', [AssignUserToRoleController::class, 'index'])->name('assign.user.index');
        Route::get('assign-user/create', [AssignUserToRoleController::class, 'create'])->name('assign.user.create');
        Route::post('assign-user', [AssignUserToRoleController::class, 'store'])->name('assign.user.store');
        Route::get('assing-user/{user}/edit', [AssignUserToRoleController::class, 'edit'])->name('assign.user.edit');
        Route::put('assign-user/{user}', [AssignUserToRoleController::class, 'update'])->name('assign.user.update');
    });
    Route::prefix('master-data')->group(function () {
        Route::post('tahun/import', [TahunController::class, 'import'])->name('tahun.import');
        Route::get('tahun/export', [TahunController::class, 'export'])->name('tahun.export');
        Route::resource('tahun', TahunController::class);

        Route::post('kecamatan/import', [KecamatanController::class, 'import'])->name('kecamatan.import');
        Route::get('kecamatan/export', [KecamatanController::class, 'export'])->name('kecamatan.export');
        Route::resource('kecamatan', KecamatanController::class);

        Route::resource('kelurahan', KelurahanController::class);
        Route::resource('daerah', DaerahController::class);
        Route::get('/getKelurahans', [DaerahController::class, 'getKelurahans'])->name('getKelurahans');
    });
    Route::prefix('lelang')->group(function () {
        Route::resource('daftar', DaftarController::class);
        Route::resource('tkd', TkdController::class);
        Route::resource('penawaran', PenawaranController::class);
    });
});
