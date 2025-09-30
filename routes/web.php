<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\RiwayatSuratController;
use App\Http\Controllers\DisposisiSuratController;
use App\Http\Controllers\ArsipSuratController;
use App\Http\Controllers\KlasifikasiSuratController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanWebsiteController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\LogAktivitasController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\UploadSuratController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Manajemen Surat
    Route::prefix('surat')->group(function () {
        // Surat Masuk
        Route::get('/masuk', [SuratMasukController::class, 'index'])->name('surat.masuk.index');
        Route::get('/masuk/create', [SuratMasukController::class, 'create'])->name('surat.masuk.create');
        Route::post('/masuk', [SuratMasukController::class, 'store'])->name('surat.masuk.store');
        Route::get('/masuk/{id}/edit', [SuratMasukController::class, 'edit'])->name('surat.masuk.edit');
        Route::put('/masuk/{id}', [SuratMasukController::class, 'update'])->name('surat.masuk.update');
        Route::delete('/masuk/{id}', [SuratMasukController::class, 'destroy'])->name('surat.masuk.destroy');
        Route::put('/masuk/{id}/arsip', [SuratMasukController::class, 'arsip'])->name('surat.masuk.arsip');
        Route::get('/masuk/{id}', [SuratMasukController::class, 'show'])->name('surat.masuk.show');
        
        // Fitur tambahan untuk Surat Masuk
        Route::post('/masuk/mark-as-read', [SuratMasukController::class, 'markAsRead'])->name('surat.masuk.mark-as-read');
        Route::post('/masuk/export', [SuratMasukController::class, 'export'])->name('surat.masuk.export');
        Route::post('/masuk/upload', [SuratMasukController::class, 'upload'])->name('surat.masuk.upload');

        // Surat Keluar
        Route::get('/keluar', [SuratKeluarController::class, 'index'])->name('surat.keluar.index');
        Route::get('/keluar/create', [SuratKeluarController::class, 'create'])->name('surat.keluar.create');
        Route::post('/keluar', [SuratKeluarController::class, 'store'])->name('surat.keluar.store');
        Route::get('/keluar/{id}/edit', [SuratKeluarController::class, 'edit'])->name('surat.keluar.edit');
        Route::put('/keluar/{id}', [SuratKeluarController::class, 'update'])->name('surat.keluar.update');
        Route::delete('/keluar/{id}', [SuratKeluarController::class, 'destroy'])->name('surat.keluar.destroy');
        Route::put('/keluar/{id}/arsip', [SuratKeluarController::class, 'arsip'])->name('surat.keluar.arsip');
        Route::get('/keluar/{id}', [SuratKeluarController::class, 'show'])->name('surat.keluar.show');
        
        // Fitur tambahan untuk Surat Keluar (opsional, bisa ditambahkan nanti)
        Route::post('/keluar/mark-as-sent', [SuratKeluarController::class, 'markAsSent'])->name('surat.keluar.mark-as-sent');
        Route::post('/keluar/export', [SuratKeluarController::class, 'export'])->name('surat.keluar.export');
        Route::post('/keluar/upload', [SuratKeluarController::class, 'upload'])->name('surat.keluar.upload');

        // Riwayat
        Route::get('/riwayat', [RiwayatSuratController::class, 'index'])->name('surat.riwayat.index');
        Route::get('/riwayat/export', [RiwayatSuratController::class, 'export'])->name('surat.riwayat.export');
       
        // Disposisi
        Route::get('/disposisi', [DisposisiSuratController::class, 'index'])->name('surat.disposisi.index');
        Route::get('/disposisi/create', [DisposisiSuratController::class, 'create'])->name('surat.disposisi.create');
        Route::post('/disposisi', [DisposisiSuratController::class, 'store'])->name('surat.disposisi.store');
        Route::get('/disposisi/{id}', [DisposisiSuratController::class, 'show'])->name('surat.disposisi.show');
        Route::get('/disposisi/{id}/edit', [DisposisiSuratController::class, 'edit'])->name('surat.disposisi.edit');
        Route::put('/disposisi/{id}', [DisposisiSuratController::class, 'update'])->name('surat.disposisi.update');
        Route::delete('/disposisi/{id}', [DisposisiSuratController::class, 'destroy'])->name('surat.disposisi.destroy');
        
        // Fitur tambahan untuk Disposisi
        Route::post('/disposisi/bulk-update-status', [DisposisiSuratController::class, 'bulkUpdateStatus'])->name('surat.disposisi.bulk-update-status');
        Route::post('/disposisi/export', [DisposisiSuratController::class, 'export'])->name('surat.disposisi.export');

        // Arsip Umum
        Route::get('/arsip', [ArsipSuratController::class, 'index'])->name('surat.arsip.index');
        Route::put('/arsip/{jenis}/{id}/restore', [ArsipSuratController::class, 'restore'])->name('surat.arsip.restore');
        Route::delete('/arsip/{jenis}/{id}/permanent-delete', [ArsipSuratController::class, 'permanentDelete'])->name('surat.arsip.permanent-delete');
        
        // Fitur tambahan untuk Arsip
        Route::post('/arsip/bulk-restore', [ArsipSuratController::class, 'bulkRestore'])->name('surat.arsip.bulk-restore');
        Route::post('/arsip/bulk-permanent-delete', [ArsipSuratController::class, 'bulkPermanentDelete'])->name('surat.arsip.bulk-permanent-delete');
        Route::post('/arsip/export', [ArsipSuratController::class, 'export'])->name('surat.arsip.export');
    });

    // Klasifikasi Surat
    Route::resource('klasifikasi', KlasifikasiSuratController::class);
    // Fitur tambahan untuk Klasifikasi
    Route::post('/klasifikasi/bulk-delete', [KlasifikasiSuratController::class, 'bulkDelete'])->name('klasifikasi.bulk-delete');
    Route::post('/klasifikasi/export', [KlasifikasiSuratController::class, 'export'])->name('klasifikasi.export');

    // Daftar Kontak
    Route::resource('kontak', KontakController::class);
    // Fitur tambahan untuk Kontak
    Route::post('/kontak/bulk-delete', [KontakController::class, 'bulkDelete'])->name('kontak.bulk-delete');
    Route::post('/kontak/export', [KontakController::class, 'export'])->name('kontak.export');
    Route::post('/kontak/import', [KontakController::class, 'import'])->name('kontak.import');

    // Manajemen File
    Route::resource('file', FileController::class);
    // Fitur tambahan untuk File
    Route::post('/file/bulk-delete', [FileController::class, 'bulkDelete'])->name('file.bulk-delete');
    Route::get('/file/{id}/download', [FileController::class, 'download'])->name('file.download');

    // Laporan Surat
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    Route::get('/laporan/print', [LaporanController::class, 'print'])->name('laporan.print');
    
    // API untuk laporan (untuk AJAX calls)
    Route::get('/api/laporan/statistics', [LaporanController::class, 'getStatistics'])->name('api.laporan.statistics');
    Route::get('/api/laporan/chart-data', [LaporanController::class, 'getChartData'])->name('api.laporan.chart-data');

    // Pengaturan Sistem
    Route::prefix('pengaturan')->group(function () {
        Route::get('/website', [PengaturanWebsiteController::class, 'index'])->name('pengaturan.website.index');
        Route::post('/website/update', [PengaturanWebsiteController::class, 'update'])->name('pengaturan.website.update');
        Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('pengaturan.notifikasi.index');
        Route::get('/notification-settings', [NotifikasiController::class, 'edit'])->name('notification-settings.edit');
        Route::put('/notification-settings', [NotifikasiController::class, 'update'])->name('notification-settings.update');
        
        // Fitur tambahan untuk Pengaturan
        Route::post('/backup', [PengaturanWebsiteController::class, 'createBackup'])->name('pengaturan.backup');
        Route::get('/backup/download/{filename}', [PengaturanWebsiteController::class, 'downloadBackup'])->name('pengaturan.backup.download');
        Route::delete('/backup/{filename}', [PengaturanWebsiteController::class, 'deleteBackup'])->name('pengaturan.backup.delete');
    });

    // Manajemen Pengguna
    Route::resource('users', UserController::class);
    // Fitur tambahan untuk Users
    Route::post('/users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulk-delete');
    Route::post('/users/bulk-activate', [UserController::class, 'bulkActivate'])->name('users.bulk-activate');
    Route::post('/users/bulk-deactivate', [UserController::class, 'bulkDeactivate'])->name('users.bulk-deactivate');
    Route::post('/users/export', [UserController::class, 'export'])->name('users.export');
    Route::get('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

    // Profil resource
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/update-password', [ProfilController::class, 'updatePassword'])->name('profil.update.password');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::post('/profil/upload-avatar', [ProfilController::class, 'uploadAvatar'])->name('profil.upload.avatar');

    // Log Aktivitas
    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log.index');
    Route::delete('/log-aktivitas/clear', [LogAktivitasController::class, 'clear'])->name('log.clear');
    Route::post('/log-aktivitas/export', [LogAktivitasController::class, 'export'])->name('log.export');

    // Upload Surat (Global upload handler)
    Route::post('/upload', [UploadSuratController::class, 'upload'])->name('upload');
    Route::delete('/upload/{filename}', [UploadSuratController::class, 'deleteUpload'])->name('upload.delete');

    // Pengaturan Website site
    Route::get('/pengaturan-sistem/site', [PengaturanWebsiteController::class, 'site'])->name('sistem.site');
    Route::post('/pengaturan-sistem/site/update', [PengaturanWebsiteController::class, 'updateSite'])->name('sistem.site.update');

    // API Routes untuk AJAX calls
    Route::prefix('api')->group(function () {
        // Dashboard API
        Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('api.dashboard.stats');
        Route::get('/dashboard/recent-letters', [DashboardController::class, 'getRecentLetters'])->name('api.dashboard.recent-letters');
        
        // Notifications API
        Route::get('/notifications', [NotifikasiController::class, 'getNotifications'])->name('api.notifications');
        Route::post('/notifications/{id}/mark-as-read', [NotifikasiController::class, 'markAsRead'])->name('api.notifications.mark-as-read');
        Route::post('/notifications/mark-all-as-read', [NotifikasiController::class, 'markAllAsRead'])->name('api.notifications.mark-all-as-read');
        
        // Search API
        Route::get('/search/letters', [SuratMasukController::class, 'searchLetters'])->name('api.search.letters');
        Route::get('/search/contacts', [KontakController::class, 'searchContacts'])->name('api.search.contacts');
        
        // Auto-complete API
        Route::get('/autocomplete/senders', [SuratMasukController::class, 'getSenders'])->name('api.autocomplete.senders');
        Route::get('/autocomplete/recipients', [SuratKeluarController::class, 'getRecipients'])->name('api.autocomplete.recipients');
        Route::get('/autocomplete/subjects', [SuratMasukController::class, 'getSubjects'])->name('api.autocomplete.subjects');
    });

    // File Download Routes (with security check)
    Route::get('/download/surat-masuk/{id}', [SuratMasukController::class, 'downloadFile'])->name('download.surat-masuk');
    Route::get('/download/surat-keluar/{id}', [SuratKeluarController::class, 'downloadFile'])->name('download.surat-keluar');
    Route::get('/download/disposisi/{id}', [DisposisiSuratController::class, 'downloadFile'])->name('download.disposisi');

    // Preview Routes (for PDF and image files)
    Route::get('/preview/surat-masuk/{id}', [SuratMasukController::class, 'previewFile'])->name('preview.surat-masuk');
    Route::get('/preview/surat-keluar/{id}', [SuratKeluarController::class, 'previewFile'])->name('preview.surat-keluar');
    Route::get('/preview/disposisi/{id}', [DisposisiSuratController::class, 'previewFile'])->name('preview.disposisi');

    // Shortcut routes untuk admin
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/system-info', [PengaturanWebsiteController::class, 'systemInfo'])->name('admin.system-info');
        Route::post('/clear-cache', [PengaturanWebsiteController::class, 'clearCache'])->name('admin.clear-cache');
        Route::post('/optimize', [PengaturanWebsiteController::class, 'optimize'])->name('admin.optimize');
        Route::get('/logs', [LogAktivitasController::class, 'systemLogs'])->name('admin.logs');
    });
});

require __DIR__.'/auth.php';