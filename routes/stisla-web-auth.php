<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\BackupDatabaseController;
use App\Http\Controllers\CrudExampleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DropboxController;
use App\Http\Controllers\GroupMenuController;
use App\Http\Controllers\MenuManagementController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionGroupController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestLogController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\UbuntuController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\YoutubeController;
use App\Http\Middleware\FileManagerPermission;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberAuthController;
use App\Http\Controllers\KategoriController;
use App\Models\Kategori;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\PengarangController;
use App\Http\Controllers\SaldoTopupController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\SaldoHistoryController;

# DASHBOARD
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::post('dashboard', [DashboardController::class, 'post']);

# SETTINGS
Route::get('settings/all', [SettingController::class, 'allSetting'])->name('settings.all');
Route::get('settings/{type}', [SettingController::class, 'index'])->name('settings.index');
Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

# PROFILE
Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
Route::put('profile', [ProfileController::class, 'update']);
Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
Route::put('profile/email', [ProfileController::class, 'updateEmail'])->name('profile.update-email');

# EXAMPLE STISLA
Route::view('datatable', 'stisla.examples.datatable.index')->name('datatable.index');
Route::view('form', 'stisla.examples.form.index')->name('form.index');
Route::view('chart-js', 'stisla.examples.chart-js.index')->name('chart-js.index');
Route::view('pricing', 'stisla.examples.pricing.index')->name('pricing.index');
Route::view('invoice', 'stisla.examples.invoice.index')->name('invoice.index');

# PENDUDUK
Route::resource('persons', PersonController::class);

# USER MANAGEMENT
Route::prefix('user-management')->as('user-management.')->group(function () {
    Route::get('users/force-login/{user}', [UserManagementController::class, 'forceLogin'])->name('users.force-login');
    Route::get('users/pdf', [UserManagementController::class, 'pdf'])->name('users.pdf');
    Route::get('users/csv', [UserManagementController::class, 'csv'])->name('users.csv');
    Route::get('users/excel', [UserManagementController::class, 'excel'])->name('users.excel');
    Route::get('users/json', [UserManagementController::class, 'json'])->name('users.json');
    Route::get('users/import-excel-example', [UserManagementController::class, 'importExcelExample'])->name('users.import-excel-example');
    Route::post('users/import-excel', [UserManagementController::class, 'importExcel'])->name('users.import-excel');
    Route::resource('users', UserManagementController::class);

    # ROLES
    Route::get('roles/pdf', [RoleController::class, 'pdf'])->name('roles.pdf');
    Route::get('roles/csv', [RoleController::class, 'csv'])->name('roles.csv');
    Route::get('roles/excel', [RoleController::class, 'excel'])->name('roles.excel');
    Route::get('roles/json', [RoleController::class, 'json'])->name('roles.json');
    Route::get('roles/import-excel-example', [RoleController::class, 'importExcelExample'])->name('roles.import-excel-example');
    Route::post('roles/import-excel', [RoleController::class, 'importExcel'])->name('roles.import-excel');
    Route::resource('roles', RoleController::class);

    # PERMISSIONS
    Route::get('permissions/pdf', [PermissionController::class, 'pdf'])->name('permissions.pdf');
    Route::get('permissions/csv', [PermissionController::class, 'csv'])->name('permissions.csv');
    Route::get('permissions/excel', [PermissionController::class, 'excel'])->name('permissions.excel');
    Route::get('permissions/json', [PermissionController::class, 'json'])->name('permissions.json');
    Route::get('permissions/import-excel-example', [PermissionController::class, 'importExcelExample'])->name('permissions.import-excel-example');
    Route::post('permissions/import-excel', [PermissionController::class, 'importExcel'])->name('permissions.import-excel');
    Route::resource('permissions', PermissionController::class);

    # GROUP PERMISSIONS
    Route::get('permission-groups/pdf', [PermissionGroupController::class, 'pdf'])->name('permission-groups.pdf');
    Route::get('permission-groups/csv', [PermissionGroupController::class, 'csv'])->name('permission-groups.csv');
    Route::get('permission-groups/excel', [PermissionGroupController::class, 'excel'])->name('permission-groups.excel');
    Route::get('permission-groups/json', [PermissionGroupController::class, 'json'])->name('permission-groups.json');
    Route::get('permission-groups/import-excel-example', [PermissionGroupController::class, 'importExcelExample'])->name('permission-groups.import-excel-example');
    Route::post('permission-groups/import-excel', [PermissionGroupController::class, 'importExcel'])->name('permission-groups.import-excel');
    Route::get('permission-groups/import-excel-example', [PermissionGroupController::class, 'importExcelExample'])->name('permission-groups.import-excel-example');
    Route::post('permission-groups/import-excel', [PermissionGroupController::class, 'importExcel'])->name('permission-groups.import-excel');
    Route::resource('permission-groups', PermissionGroupController::class);
});

# ACTIVITY LOGS
Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
Route::get('activity-logs/print', [ActivityLogController::class, 'exportPrint'])->name('activity-logs.print');
Route::get('activity-logs/pdf', [ActivityLogController::class, 'pdf'])->name('activity-logs.pdf');
Route::get('activity-logs/csv', [ActivityLogController::class, 'csv'])->name('activity-logs.csv');
Route::get('activity-logs/json', [ActivityLogController::class, 'json'])->name('activity-logs.json');
Route::get('activity-logs/excel', [ActivityLogController::class, 'excel'])->name('activity-logs.excel');

# REQUEST LOGS
Route::get('request-logs', [RequestLogController::class, 'index'])->name('request-logs.index');
Route::get('request-logs/print', [RequestLogController::class, 'exportPrint'])->name('request-logs.print');
Route::get('request-logs/pdf', [RequestLogController::class, 'pdf'])->name('request-logs.pdf');
Route::get('request-logs/csv', [RequestLogController::class, 'csv'])->name('request-logs.csv');
Route::get('request-logs/json', [RequestLogController::class, 'json'])->name('request-logs.json');
Route::get('request-logs/excel', [RequestLogController::class, 'excel'])->name('request-logs.excel');

# NOTIFICATIONS
Route::get('notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
Route::get('notifications/read/{notification}', [NotificationController::class, 'read'])->name('notifications.read');
Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');

# BACKUP DATABASE
Route::resource('backup-databases', BackupDatabaseController::class);

# FILE MANAGER
Route::group(['prefix' => 'file-managers', 'middleware' => [FileManagerPermission::class]], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

# LOG VIEWER
Route::get('logs-viewer', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('logs.index')->middleware('can:Laravel Log Viewer');

# YOUTUBE VIEWER (SECRET MENU)
Route::get('youtube-viewer', [YoutubeController::class, 'viewer'])->name('youtube.viewer');
Route::get('youtube-viewer-per-video', [YoutubeController::class, 'viewerPerVideo'])->name('youtube.viewer-per-video');

# UBUNTU
Route::get('ubuntu/laravel-seeder/{seeder}', [UbuntuController::class, 'laravelSeeder'])->name('ubuntu.laravelSeeder');
Route::get('ubuntu/laravel-migrate', [UbuntuController::class, 'laravelMigrate'])->name('ubuntu.laravelMigrate');
Route::get('ubuntu/laravel-migrate-refresh', [UbuntuController::class, 'laravelMigrateRefresh'])->name('ubuntu.laravelMigrateRefresh');
Route::get('ubuntu/supervisor/{action}', [UbuntuController::class, 'supervisor'])->name('ubuntu.supervisor');
Route::get('ubuntu/php-fpm/{version}/{action}', [UbuntuController::class, 'phpFpm'])->name('ubuntu.php-fpm');
Route::get('ubuntu/mysql/{action}', [UbuntuController::class, 'mysql'])->name('ubuntu.mysql');
Route::get('ubuntu/mysql/{database?}/{table?}/{action?}', [UbuntuController::class, 'index'])->name('ubuntu.mysql-paginate');
Route::get('ubuntu/edit-row/{database}/{table}/{id}', [UbuntuController::class, 'editRow'])->name('ubuntu.edit-row');
Route::put('ubuntu/update-row/{database}/{table}/{id}', [UbuntuController::class, 'updateRow'])->name('ubuntu.update-row');
Route::delete('ubuntu/delete-row/{database}/{table}/{id}', [UbuntuController::class, 'deleteRow'])->name('ubuntu.delete-row');
Route::get('ubuntu/nginx', [UbuntuController::class, 'nginx'])->name('ubuntu.nginx');
Route::post('ubuntu/create-database', [UbuntuController::class, 'createDb'])->name('ubuntu.create-db');
Route::get('ubuntu/{pathname}/toggle-ssl/{nextStatus}', [UbuntuController::class, 'toggleSSL'])->name('ubuntu.toggle-ssl');
Route::get('ubuntu/{pathname}/toggle-enabled/{nextStatus}', [UbuntuController::class, 'toggleEnabled'])->name('ubuntu.toggle-enabled');
Route::get('ubuntu/{pathname}/duplicate', [UbuntuController::class, 'duplicate'])->name('ubuntu.duplicate');
Route::get('ubuntu/{pathname}/git-pull', [UbuntuController::class, 'gitPull'])->name('ubuntu.git-pull');
Route::get('ubuntu/{pathname}/set-laravel-permission', [UbuntuController::class, 'setLaravelPermission'])->name('ubuntu.set-laravel-permission');
Route::resource('ubuntu', UbuntuController::class);

# MANAJEMEN MENU
Route::get('menu-managements/pdf', [MenuManagementController::class, 'pdf'])->name('menu-managements.pdf');
Route::get('menu-managements/csv', [MenuManagementController::class, 'csv'])->name('menu-managements.csv');
Route::get('menu-managements/excel', [MenuManagementController::class, 'excel'])->name('menu-managements.excel');
Route::get('menu-managements/json', [MenuManagementController::class, 'json'])->name('menu-managements.json');
Route::get('menu-managements/import-excel-example', [MenuManagementController::class, 'importExcelExample'])->name('menu-managements.import-excel-example');
Route::post('menu-managements/import-excel', [MenuManagementController::class, 'importExcel'])->name('menu-managements.import-excel');
Route::get('menu-managements/import-excel-example', [MenuManagementController::class, 'importExcelExample'])->name('menu-managements.import-excel-example');
Route::post('menu-managements/import-excel', [MenuManagementController::class, 'importExcel'])->name('menu-managements.import-excel');
Route::resource('menu-managements', MenuManagementController::class);

Route::resource('group-menus', GroupMenuController::class);

# CONTOH CRUD
Route::get('yajra-crud-examples', [CrudExampleController::class, 'index'])->name('crud-examples.index-yajra');
Route::get('yajra-crud-examples/ajax', [CrudExampleController::class, 'yajraAjax'])->name('crud-examples.ajax-yajra');
Route::get('ajax-crud-examples', [CrudExampleController::class, 'index'])->name('crud-examples.index-ajax');
Route::get('yajra-ajax-crud-examples', [CrudExampleController::class, 'index'])->name('crud-examples.index-ajax-yajra');

Route::get('crud-examples/pdf', [CrudExampleController::class, 'exportPdf'])->name('crud-examples.pdf');
Route::get('crud-examples/csv', [CrudExampleController::class, 'exportCsv'])->name('crud-examples.csv');
Route::get('crud-examples/excel', [CrudExampleController::class, 'exportExcel'])->name('crud-examples.excel');
Route::get('crud-examples/json', [CrudExampleController::class, 'exportJson'])->name('crud-examples.json');

Route::get('crud-examples/import-excel-example', [CrudExampleController::class, 'importExcelExample'])->name('crud-examples.import-excel-example');
Route::post('crud-examples/import-excel', [CrudExampleController::class, 'importExcel'])->name('crud-examples.import-excel');
Route::resource('crud-examples', CrudExampleController::class);

Route::get('testing/datatable', [TestingController::class, 'datatable']);
Route::get('testing/send-email', [TestingController::class, 'sendEmail']);
Route::get('testing/modal', [TestingController::class, 'modal']);

# DROPBOX
Route::get('dropboxs', [DropboxController::class, 'index'])->name('dropboxs.index');
Route::post('dropboxs', [DropboxController::class, 'upload'])->name('dropboxs.upload');
Route::delete('dropboxs', [DropboxController::class, 'destroy'])->name('dropboxs.destroy');

Route::middleware(['auth'])->group(function () {
    Route::resource('pegawai', PegawaiController::class);
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
    Route::get('/pdf', [PegawaiController::class, 'exportPdf'])->name('pegawai.pdf');
    Route::get('/print', [PegawaiController::class, 'exportPrint'])->name('pegawai.print');
    Route::get('/excel', [PegawaiController::class, 'exportExcel'])->name('pegawai.excel');
    Route::get('/csv', [PegawaiController::class, 'exportCsv'])->name('pegawai.csv');
    Route::get('/json', [PegawaiController::class, 'exportJson'])->name('pegawai.json');
});


Route::prefix('member')->middleware(['auth'])->group(function () {
    Route::get('/', [MemberController::class, 'index'])->name('member.index');
    Route::post('/store', [MemberController::class, 'store'])->name('member.store');
    Route::put('/update/{id}', [MemberController::class, 'update'])->name('member.update');
    Route::get('/edit/{id}', [MemberController::class, 'edit'])->name('member.edit');
    Route::delete('/delete/{id}', [MemberController::class, 'destroy'])->name('member.destroy');

    // Export
    Route::get('/pdf', [MemberController::class, 'exportPdf'])->name('member.pdf');
    Route::get('/excel', [MemberController::class, 'exportExcel'])->name('member.excel');
    Route::get('/csv', [MemberController::class, 'exportCsv'])->name('member.csv');
    Route::get('/json', [MemberController::class, 'exportJson'])->name('member.json');
    Route::post('/import', [MemberController::class, 'import'])->name('member.import');
});
Route::get('/setting', [\App\Http\Controllers\SettingController::class, 'index'])->name('setting.index');
Route::post('/setting', [\App\Http\Controllers\SettingController::class, 'update'])->name('setting.update');

Route::prefix('kategori')->middleware(['auth'])->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Ekspor
    Route::get('/pdf', [KategoriController::class, 'exportPdf'])->name('kategori.pdf');
    Route::get('/excel', [KategoriController::class, 'exportExcel'])->name('kategori.excel');
    Route::get('/csv', [KategoriController::class, 'exportCsv'])->name('kategori.csv');
    Route::get('/json', [KategoriController::class, 'exportJson'])->name('kategori.json');
    Route::post('/import', [KategoriController::class, 'import'])->name('member.import');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/penerbit', [PenerbitController::class, 'index'])->name('penerbit.index');
    Route::post('/penerbit', [PenerbitController::class, 'store'])->name('penerbit.store');
    Route::get('/penerbit/{id}/edit', [PenerbitController::class, 'edit'])->name('penerbit.edit');
    Route::put('/penerbit/{id}', [PenerbitController::class, 'update'])->name('penerbit.update');
    Route::delete('/penerbit/{id}', [PenerbitController::class, 'destroy'])->name('penerbit.destroy');

    // Exports
    Route::get('/penerbit/pdf', [PenerbitController::class, 'exportPdf'])->name('penerbit.pdf');
    Route::get('/penerbit/excel', [PenerbitController::class, 'exportExcel'])->name('penerbit.excel');
    Route::get('/penerbit/csv', [PenerbitController::class, 'exportCsv'])->name('penerbit.csv');
    Route::get('/penerbit/json', [PenerbitController::class, 'exportJson'])->name('penerbit.json');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pengarang', [PengarangController::class, 'index'])->name('pengarang.index');
    Route::post('/pengarang', [PengarangController::class, 'store'])->name('pengarang.store');
    Route::get('/pengarang/{id}/edit', [PengarangController::class, 'edit'])->name('pengarang.edit');
    Route::put('/pengarang/{id}', [PengarangController::class, 'update'])->name('pengarang.update');
    Route::delete('/pengarang/{id}', [PengarangController::class, 'destroy'])->name('pengarang.destroy');

    // Exports
    Route::get('/pengarang/pdf', [PengarangController::class, 'exportPdf'])->name('pengarang.pdf');
    Route::get('/pengarang/excel', [PengarangController::class, 'exportExcel'])->name('pengarang.excel');
    Route::get('/pengarang/csv', [PengarangController::class, 'exportCsv'])->name('pengarang.csv');
    Route::get('/pengarang/json', [PengarangController::class, 'exportJson'])->name('pengarang.json');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/topup', [SaldoTopupController::class, 'index'])->name('topup.index');
    Route::get('/topup/create', [SaldoTopupController::class, 'create'])->name('topup.create');
    Route::post('/topup/store', [SaldoTopupController::class, 'store'])->name('topup.store');

    Route::post('/topup/{id}/approve', [SaldoTopupController::class, 'approve'])->name('topup.approve');
    Route::post('/topup/{id}/reject', [SaldoTopupController::class, 'reject'])->name('topup.reject');

    Route::get('/topup/pdf', [SaldoTopupController::class, 'exportPdf'])->name('topup.pdf');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::post('/buku/store', [BukuController::class, 'store'])->name('buku.store');
    Route::put('/buku/update/{id}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/delete/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');

    // Export PDF
    Route::get('/buku/pdf', [BukuController::class, 'exportPdf'])->name('buku.pdf');

    // Tampilan khusus untuk member (show semua buku dalam bentuk kartu)
    Route::get('/buku/show', [BukuController::class, 'show'])->name('buku.show');
    Route::get('/buku/export/pdf', [BukuController::class, 'exportPdf'])->name('buku.exportPdf');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/history', [SaldoHistoryController::class, 'index'])->name('history.index');
    Route::get('/history/export/pdf', [SaldoHistoryController::class, 'exportPdf'])->name('history.exportPdf');
});
