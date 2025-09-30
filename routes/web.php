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
        Route::put('/masuk/{id}/arsip', [SuratMasukController::class, 'arsip'])->name('surat.masuk.arsip'); // perbaikan: PUT
        Route::get('/masuk/{id}', [SuratMasukController::class, 'show'])->name('surat.masuk.show');
    
        // Surat Keluar
        Route::get('/keluar', [SuratKeluarController::class, 'index'])->name('surat.keluar.index');
        Route::get('/keluar/create', [SuratKeluarController::class, 'create'])->name('surat.keluar.create');
        Route::post('/keluar', [SuratKeluarController::class, 'store'])->name('surat.keluar.store');
        Route::get('/keluar/{id}/edit', [SuratKeluarController::class, 'edit'])->name('surat.keluar.edit');
        Route::put('/keluar/{id}', [SuratKeluarController::class, 'update'])->name('surat.keluar.update');
        Route::delete('/keluar/{id}', [SuratKeluarController::class, 'destroy'])->name('surat.keluar.destroy');
        Route::put('/keluar/{id}/arsip', [SuratKeluarController::class, 'arsip'])->name('surat.keluar.arsip'); // perbaikan: PUT
        //show
        Route::get('/keluar/{id}', [SuratKeluarController::class, 'show'])->name('surat.keluar.show');

    
        // Riwayat
        Route::get('/riwayat', [RiwayatSuratController::class, 'index'])->name('surat.riwayat.index');
       
        //disposisi
        Route::get('/disposisi', [DisposisiSuratController::class, 'index'])->name('surat.disposisi.index');
        Route::get('/disposisi/create', [DisposisiSuratController::class, 'create'])->name('surat.disposisi.create');
        Route::post('/disposisi', [DisposisiSuratController::class, 'store'])->name('surat.disposisi.store');
        Route::get('/disposisi/{id}', [DisposisiSuratController::class, 'show'])->name('surat.disposisi.show');
        Route::put('/disposisi/{id}', [DisposisiSuratController::class, 'update'])->name('surat.disposisi.update');
    
        // Arsip Umum
        Route::get('/arsip', [ArsipSuratController::class, 'index'])->name('surat.arsip.index');
        Route::put('/arsip/{jenis}/{id}/restore', [ArsipSuratController::class, 'restore'])->name('surat.arsip.restore');
    
    });
    // Klasifikasi Surat
    Route::resource('klasifikasi', KlasifikasiSuratController::class);

    // Daftar Kontak
    Route::resource('kontak', KontakController::class);

    // Manajemen File
    Route::resource('file', FileController::class);

    // Laporan Surat
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

    // Pengaturan Sistem
    Route::prefix('pengaturan')->group(function () {
        Route::get('/website', [PengaturanWebsiteController::class, 'index'])->name('pengaturan.website.index');
        Route::post('/website/update', [PengaturanWebsiteController::class, 'update'])->name('pengaturan.website.update');

        Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('pengaturan.notifikasi.index');
        Route::get('/notification-settings', [NotifikasiController::class, 'edit'])->name('notification-settings.edit');
        Route::put('/notification-settings', [NotifikasiController::class, 'update'])->name('notification-settings.update');
    });

    // Manajemen Pengguna
    Route::resource('users', UserController::class);

    // Profil resource
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/update-password', [ProfilController::class, 'updatePassword'])->name('profil.update.password');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');


    // Log Aktivitas
    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log.index');

    // Upload Surat
    Route::post('/upload', [UploadSuratController::class, 'upload'])->name('upload');

    //PengaturanWebsite site
    Route::get('/pengaturan-sistem/site', [PengaturanWebsiteController::class, 'site'])->name('sistem.site');
    Route::post('/pengaturan-sistem/site/update', [PengaturanWebsiteController::class, 'updateSite'])->name('sistem.site.update');
    //PengaturanWebsite notifikasi

    //PengaturanWebsite email 
    

});

require __DIR__.'/auth.php';
