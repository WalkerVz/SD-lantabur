<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SdmController;
use App\Http\Controllers\Admin\StrukturOrganisasiController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\RaportController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home']);
Route::view('/about', 'about');
Route::view('/contact', 'contact');
Route::get('/staff', [PageController::class, 'staff']);
Route::get('/news', [PageController::class, 'news']);
Route::get('/news/{id}', [PageController::class, 'newsShow'])->name('news.show');
Route::get('/gallery', [PageController::class, 'gallery']);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('admin');

    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('sdm', [SdmController::class, 'index'])->name('sdm.index');
        Route::get('sdm/create', [SdmController::class, 'create'])->name('sdm.create');
        Route::post('sdm', [SdmController::class, 'store'])->name('sdm.store');
        Route::get('sdm/{id}/edit', [SdmController::class, 'edit'])->name('sdm.edit');
        Route::put('sdm/{id}', [SdmController::class, 'update'])->name('sdm.update');
        Route::delete('sdm/{id}', [SdmController::class, 'destroy'])->name('sdm.destroy');

        Route::get('struktur', [StrukturOrganisasiController::class, 'index'])->name('struktur.index');
        Route::get('struktur/create', [StrukturOrganisasiController::class, 'create'])->name('struktur.create');
        Route::post('struktur', [StrukturOrganisasiController::class, 'store'])->name('struktur.store');
        Route::get('struktur/{id}/edit', [StrukturOrganisasiController::class, 'edit'])->name('struktur.edit');
        Route::put('struktur/{id}', [StrukturOrganisasiController::class, 'update'])->name('struktur.update');
        Route::delete('struktur/{id}', [StrukturOrganisasiController::class, 'destroy'])->name('struktur.destroy');

        Route::get('siswa', [SiswaController::class, 'index'])->name('siswa.index');
        Route::get('siswa/list-by-kelas', [SiswaController::class, 'listByKelas'])->name('siswa.list-by-kelas');
        Route::get('siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
        Route::post('siswa', [SiswaController::class, 'store'])->name('siswa.store');
        Route::get('siswa/{id}', [SiswaController::class, 'show'])->name('siswa.show');
        Route::get('siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
        Route::put('siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
        Route::delete('siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
        Route::get('siswa/cetak-absen/kelas/{kelas}', [SiswaController::class, 'cetakAbsen'])->name('siswa.cetakAbsen');
        Route::get('siswa-promotion', [SiswaController::class, 'promotion'])->name('siswa.promotion');
        Route::post('siswa-promote', [SiswaController::class, 'promote'])->name('siswa.promote');

        Route::get('raport', [RaportController::class, 'index'])->name('raport.index');
        Route::get('raport/kelas/{kelas}', [RaportController::class, 'byKelas'])->name('raport.byKelas');
        Route::get('raport/kelas/{kelas}/create', [RaportController::class, 'create'])->name('raport.create');
        Route::post('raport', [RaportController::class, 'store'])->name('raport.store');
        Route::get('raport/{id}/edit', [RaportController::class, 'edit'])->name('raport.edit');
        Route::put('raport/{id}', [RaportController::class, 'update'])->name('raport.update');
        Route::get('raport/cetak/kelas/{kelas}', [RaportController::class, 'cetak'])->name('raport.cetak');
        Route::get('raport/cetak/siswa/{id}', [RaportController::class, 'cetakSiswa'])->name('raport.cetakSiswa');
        Route::get('raport/cetak/praktik/{id}', [RaportController::class, 'cetakPraktik'])->name('raport.cetakPraktik');
        Route::get('raport/history/{id}', [RaportController::class, 'history'])->name('raport.history');

        Route::get('news', [NewsController::class, 'index'])->name('news.index');
        Route::get('news/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('news', [NewsController::class, 'store'])->name('news.store');
        Route::get('news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
        Route::put('news/{id}', [NewsController::class, 'update'])->name('news.update');
        Route::delete('news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');

        Route::get('gallery', [GalleryController::class, 'index'])->name('gallery.index');
        Route::get('gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
        Route::post('gallery', [GalleryController::class, 'store'])->name('gallery.store');
        Route::get('gallery/{id}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
        Route::put('gallery/{id}', [GalleryController::class, 'update'])->name('gallery.update');
        Route::delete('gallery/{id}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

        Route::get('slider', [SliderController::class, 'index'])->name('slider.index');
        Route::get('slider/create', [SliderController::class, 'create'])->name('slider.create');
        Route::post('slider', [SliderController::class, 'store'])->name('slider.store');
        Route::get('slider/{id}/edit', [SliderController::class, 'edit'])->name('slider.edit');
        Route::put('slider/{id}', [SliderController::class, 'update'])->name('slider.update');
        Route::delete('slider/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');

        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
        Route::put('settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
        Route::post('settings/tahun-ajaran', [SettingsController::class, 'storeTahunAjaran'])->name('settings.tahun-ajaran.store');
        Route::put('settings/tahun-ajaran/aktif', [SettingsController::class, 'setAktifTahunAjaran'])->name('settings.tahun-ajaran.aktif');
        Route::post('settings/mapel', [SettingsController::class, 'storeMapel'])->name('settings.mapel.store');
        Route::put('settings/mapel/{id}', [SettingsController::class, 'updateMapel'])->name('settings.mapel.update');
        Route::delete('settings/mapel/{id}', [SettingsController::class, 'destroyMapel'])->name('settings.mapel.destroy');
    });
});
