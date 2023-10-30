<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\DaerahController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\GugurController;
use App\Http\Controllers\HektarController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\Menu\MenuGroupController;
use App\Http\Controllers\Menu\MenuItemController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\PejabatController;
use App\Http\Controllers\PemenangController;
use App\Http\Controllers\PenawaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\RoleAndPermission\AssignPermissionController;
use App\Http\Controllers\RoleAndPermission\AssignUserToRoleController;
use App\Http\Controllers\RoleAndPermission\ExportPermissionController;
use App\Http\Controllers\RoleAndPermission\ExportRoleController;
use App\Http\Controllers\RoleAndPermission\ImportPermissionController;
use App\Http\Controllers\RoleAndPermission\ImportRoleController;
use App\Http\Controllers\RoleAndPermission\PermissionController;
use App\Http\Controllers\RoleAndPermission\RoleController;
use App\Http\Controllers\StsController;
use App\Http\Controllers\TahunController;
use App\Http\Controllers\TkdController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Models\Category;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('auth/login');
});


Route::post('/setSessionTahun', function (Request $request) {
    $tahunId = $request->input('tahun_id');
    $kelurahanID = $request->input('kelurahan_id');
    session([
        'tahun_id' => $tahunId,
        'kelurahan_id' => $kelurahanID,
    ]);
    return response()->json(['message' => 'Tahun disimpan dalam sesi.']);
})->name('setSessionTahun');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.edit');
    Route::PUT('/update-profile-information', [ProfileController::class, 'update'])->name('profile.user.update');
    Route::get('/getDaerah', [DashboardController::class, 'requestAjaxLogin'])->name('requestAjaxLogin');
    Route::get('/total-pendaftar', [DashboardController::class, 'getTotalPendaftar']);
    Route::get('/total-tkd', [DashboardController::class, 'getTotalTkd']);
    Route::get('/total-penawaran', [DashboardController::class, 'getTotalPenawaran'])->name('getTotalPenawaran');
    Route::get('/total-daerah', [DashboardController::class, 'getTotalDaerah'])->name('getTotalDaerah');
    Route::post('/store-selected-values', [DashboardController::class, 'storeSelectedValues'])
        ->name('storeSelectedValues');
    Route::get('/getKelurahansDashboard', [DashboardController::class, 'getKelurahansDashboard'])->name('getKelurahansDashboard');
    Route::post('/storeJquery', [DaerahController::class, 'storeJquery'])->name('storeJquery');


    Route::prefix('user-management')->group(function () {
        Route::resource('user', UserController::class);
        Route::post('import', [UserController::class, 'import'])->name('user.import');
        Route::get('export', [UserController::class, 'export'])->name('user.export');
        Route::get('demo', DemoController::class)->name('user.demo');

        Route::post('jabatan/import', [JabatanController::class, 'import'])->name('jabatan.import')->middleware('check.kelurahan');
        Route::get('jabatan/export', [JabatanController::class, 'export'])->name('jabatan.export')->middleware('check.kelurahan');
        Route::resource('jabatan', JabatanController::class)->middleware('check.kelurahan');

        Route::post('pejabat/import', [PejabatController::class, 'import'])->name('pejabat.import')->middleware('check.kelurahan');
        Route::get('pejabat/export', [PejabatController::class, 'export'])->name('pejabat.export')->middleware('check.kelurahan');
        Route::resource('pejabat', PejabatController::class)->middleware('check.kelurahan');

        Route::post('opd/import', [OpdController::class, 'import'])->name('opd.import')->middleware('check.kelurahan');
        Route::get('opd/export', [OpdController::class, 'export'])->name('opd.export')->middleware('check.kelurahan');
        Route::resource('opd', OpdController::class)->middleware('check.kelurahan');
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

        Route::get('kelurahan/download-template', [KelurahanController::class, 'downloadTemplate'])
            ->name('kelurahan.download-template');
        Route::post('kelurahan/import', [KelurahanController::class, 'import'])->name('kelurahan.import');
        Route::get('kelurahan/export', [KelurahanController::class, 'export'])->name('kelurahan.export');
        Route::resource('kelurahan', KelurahanController::class);

        Route::get('daerah/download-template', [DaerahController::class, 'downloadTemplate'])
            ->name('daerah.download-template');
        Route::post('daerah/import', [DaerahController::class, 'import'])->name('daerah.import');
        Route::get('daerah/export', [DaerahController::class, 'export'])->name('daerah.export');
        Route::get('/getDaerahJquery', [DaerahController::class, 'getDaerahJquery'])->name('getDaerahJquery');
        Route::resource('daerah', DaerahController::class);
        Route::get('/getKelurahans', [DaerahController::class, 'getKelurahans'])->name('getKelurahans');
    });

    Route::prefix('lelang')->middleware('check.kelurahan')->group(function () {
        Route::get('daftar/download-template', [DaftarController::class, 'downloadTemplate'])
            ->name('daftar.download-template');
        Route::post('daftar/import', [DaftarController::class, 'import'])->name('daftar.import');
        Route::get('daftar/export', [DaftarController::class, 'export'])->name('daftar.export');
        Route::resource('daftar', DaftarController::class);
        Route::post('/getLatestNoUrut', [DaftarController::class, 'getLatestNoUrut'])->name('getLatestNoUrut');

        Route::get('tkd/download-template', [TkdController::class, 'downloadTemplate'])->name('tkd.download-template');
        Route::post('tkd/import', [TkdController::class, 'import'])->name('tkd.import');
        Route::get('tkd/export', [TkdController::class, 'export'])->name('tkd.export');
        Route::resource('tkd', TkdController::class);

        Route::get('/penawaran/{id}/toggle-gugur', [PenawaranController::class, 'toggleGugur'])
            ->name('penawaran.toggle-gugur');
        Route::post('penawaran/form', [PenawaranController::class, 'handleForm'])->name('penawaran.handleForm');
        Route::get('penawaran/download-template', [PenawaranController::class, 'downloadTemplate'])
            ->name('penawaran.download-template');
        Route::post('penawaran/import', [PenawaranController::class, 'import'])->name('penawaran.import');
        Route::get('penawaran/export', [PenawaranController::class, 'export'])->name('penawaran.export');
        Route::resource('penawaran', PenawaranController::class);
        Route::get('/getTkd', [PenawaranController::class, 'getTkd'])->name('getTkd');
        Route::delete('/delete-all', [PenawaranController::class, 'deleteAll'])->name('delete.all');
        Route::get('/cetaktidaklaku', [PenawaranController::class, 'cetakTidakLaku'])->name('penawaran.cetaktidaklaku');
        Route::get('/cetakba', [PenawaranController::class, 'cetakBA'])->name('penawaran.cetakba');
        Route::get('/cetaksekota', [PenawaranController::class, 'cetakSekota'])->name('penawaran.cetaksekota');

        Route::get('/dua-hektar', [HektarController::class, 'index'])->name('hektar');

        Route::get('/sts', [StsController::class, 'index'])->name('sts');
        Route::post('/sts/{id}/gugur', [StsController::class, 'gugur'])->name('sts.gugur');
        Route::post('/sts/{penawaran}/update-date', [StsController::class, 'updateDate'])->name('penawaran.updateDate');
        Route::get('/sts/{id}/print', [StsController::class, 'printSTS'])->name('sts.print');
        Route::get('/perjajian', [StsController::class, 'cetakPerjanjian'])->name('sts.cetakperjanjian');
        Route::get('/pernyataan', [StsController::class, 'cetakPernyataan'])->name('sts.cetakpernyataan');
    });

    Route::prefix('pdf')->middleware('check.kelurahan')->group(function () {
        Route::get('/cetakgugur', [GugurController::class, 'cetakGugur'])->name('cetakgugur');
        Route::get('/cetakpemenang', [PemenangController::class, 'cetakPemenang'])->name('cetakpemenang');
        Route::get('/cetakrekap', [RekapController::class, 'cetakRekap'])->name('cetakrekap');
    });
});
