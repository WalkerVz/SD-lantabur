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
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\MasterKelasController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home']);
Route::view('/about', 'about');
Route::view('/contact', 'contact');
Route::get('/staff', [PageController::class, 'staff']);
Route::get('/news', [PageController::class, 'news']);
Route::get('/news/{id}', [PageController::class, 'newsShow'])->name('news.show');
Route::get('/gallery', [PageController::class, 'gallery']);

Route::prefix('adminLantabur')->name('admin.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('admin');

    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('sdm', [SdmController::class, 'index'])->name('sdm.index');
        Route::get('sdm/export/excel', [SdmController::class, 'exportExcel'])->name('sdm.export.excel');
        Route::get('sdm/create', [SdmController::class, 'create'])->name('sdm.create');
        Route::post('sdm', [SdmController::class, 'store'])->name('sdm.store');
        Route::get('sdm/{id}/edit', [SdmController::class, 'edit'])->name('sdm.edit');
        Route::put('sdm/{id}', [SdmController::class, 'update'])->name('sdm.update');
        Route::delete('sdm/{id}', [SdmController::class, 'destroy'])->name('sdm.destroy');

        Route::get('sdm/export/pdf', [SdmController::class, 'exportPdf'])->name('sdm.export.pdf');

        Route::get('struktur', [StrukturOrganisasiController::class, 'index'])->name('struktur.index');
        Route::get('struktur/export/excel', [StrukturOrganisasiController::class, 'exportExcel'])->name('struktur.export.excel');
        Route::get('struktur/create', [StrukturOrganisasiController::class, 'create'])->name('struktur.create');
        Route::post('struktur', [StrukturOrganisasiController::class, 'store'])->name('struktur.store');
        Route::get('struktur/{id}/edit', [StrukturOrganisasiController::class, 'edit'])->name('struktur.edit');
        Route::put('struktur/{id}', [StrukturOrganisasiController::class, 'update'])->name('struktur.update');
        Route::delete('struktur/{id}', [StrukturOrganisasiController::class, 'destroy'])->name('struktur.destroy');
        Route::get('struktur/export/pdf', [StrukturOrganisasiController::class, 'exportPdf'])->name('struktur.export.pdf');

        Route::get('siswa', [SiswaController::class, 'index'])->name('siswa.index');
        Route::get('siswa/list-by-kelas', [SiswaController::class, 'listByKelas'])->name('siswa.list-by-kelas');
        Route::get('siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
        Route::post('siswa', [SiswaController::class, 'store'])->name('siswa.store');
        Route::get('siswa/{id}', [SiswaController::class, 'show'])->name('siswa.show');
        Route::get('siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
        Route::put('siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
        Route::delete('siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
        Route::delete('siswa/{id}/remove-from-class', [SiswaController::class, 'removeFromClass'])->name('siswa.removeFromClass');
        Route::get('siswa/export/pdf', [SiswaController::class, 'exportPdf'])->name('siswa.export.pdf');
        Route::get('siswa-promotion', [SiswaController::class, 'promotion'])->name('siswa.promotion');
        Route::post('siswa-promote', [SiswaController::class, 'promote'])->name('siswa.promote');

        Route::get('pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
        Route::post('pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
        Route::get('pembayaran/{id}/edit', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
        Route::put('pembayaran/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');
        Route::delete('pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
        Route::get('pembayaran/export/pdf', [PembayaranController::class, 'exportPdf'])->name('pembayaran.export.pdf');
        Route::get('pembayaran/export/semua-pdf', [PembayaranController::class, 'exportSemuaPdf'])->name('pembayaran.exportSemuaPdf');
        Route::get('pembayaran/rekap-pdf', [PembayaranController::class, 'rekapPdfPerKelas'])->name('pembayaran.rekapPdf');
        Route::get('pembayaran/rekap-semua-pdf', [PembayaranController::class, 'rekapSemuaPdfPerKelas'])->name('pembayaran.rekapSemuaPdf');
        Route::get('pembayaran/{id}/kwitansi', [PembayaranController::class, 'kwitansi'])->name('pembayaran.kwitansi');
        Route::get('raport', [RaportController::class, 'index'])->name('raport.index');
        Route::get('raport/kelas/{kelas}', [RaportController::class, 'byKelas'])->name('raport.byKelas');
        Route::get('raport/kelas/{kelas}/create', [RaportController::class, 'create'])->name('raport.create');
        Route::post('raport', [RaportController::class, 'store'])->name('raport.store');
        Route::get('raport/{id}/edit', [RaportController::class, 'edit'])->name('raport.edit');
        Route::put('raport/{id}', [RaportController::class, 'update'])->name('raport.update');
        Route::get('raport/cetak/kelas/{kelas}', [RaportController::class, 'cetak'])->name('raport.cetak');
        Route::get('raport/cetak/siswa/{id}', [RaportController::class, 'cetakSiswa'])->name('raport.cetakSiswa');
        Route::get('raport/cetak/siswa-semua/{id}', [RaportController::class, 'cetakSemua'])->name('raport.cetakSemua');
        Route::get('raport/cetak/praktik/{id}', [RaportController::class, 'cetakPraktik'])->name('raport.cetakPraktik');
        Route::get('raport/cetak/jilid/{siswaId}', [RaportController::class, 'cetakJilid'])->name('raport.cetakJilid');
        Route::get('raport/jilid/{siswaId}/edit', [RaportController::class, 'editJilid'])->name('raport.editJilid');
        Route::post('raport/jilid', [RaportController::class, 'jilidStore'])->name('raport.jilidStore');
        Route::put('raport/jilid/{id}', [RaportController::class, 'jilidUpdate'])->name('raport.jilidUpdate');
        Route::get('raport/history/{id}', [RaportController::class, 'history'])->name('raport.history');
        Route::get('raport/praktik/{id}/edit', [RaportController::class, 'editPraktik'])->name('raport.editPraktik');
        Route::get('raport/entry-praktik', [RaportController::class, 'ensureAndEditPraktik'])->name('raport.ensureAndEditPraktik');
        Route::put('raport/praktik/{id}', [RaportController::class, 'updatePraktik'])->name('raport.updatePraktik');

        // Route Raport Tahfidz Ummi
        Route::get('raport/tahfidz/{siswaId}', [RaportController::class, 'formTahfidz'])->name('raport.formTahfidz');
        Route::post('raport/tahfidz', [RaportController::class, 'tahfidzStore'])->name('raport.tahfidzStore');
        Route::put('raport/tahfidz/{id}', [RaportController::class, 'tahfidzUpdate'])->name('raport.tahfidzUpdate');
        Route::get('raport/cetak-tahfidz/{siswaId}', [RaportController::class, 'cetakTahfidz'])->name('raport.cetakTahfidz');

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
        Route::get('settings/accounts', [SettingsController::class, 'accounts'])->name('settings.accounts');
        Route::post('settings/accounts', [SettingsController::class, 'storeAccount'])->name('settings.accounts.store');
        Route::put('settings/accounts/{id}', [SettingsController::class, 'updateAccount'])->name('settings.accounts.update');
        Route::delete('settings/accounts/{id}', [SettingsController::class, 'destroyAccount'])->name('settings.accounts.destroy');
        Route::post('settings/accounts/{id}/reset-password', [SettingsController::class, 'resetAccountPassword'])->name('settings.accounts.reset-password');
        Route::get('settings/accessibility', [SettingsController::class, 'accessibility'])->name('settings.accessibility');
        Route::post('settings/accessibility', [SettingsController::class, 'saveAccessibility'])->name('settings.accessibility.save');
        Route::get('settings/contact', [SettingsController::class, 'contact'])->name('settings.contact');
        Route::post('settings/contact', [SettingsController::class, 'updateContact'])->name('settings.contact.store');
        Route::put('settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
        Route::put('settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
        Route::post('settings/tahun-ajaran', [SettingsController::class, 'storeTahunAjaran'])->name('settings.tahun-ajaran.store');
        Route::put('settings/tahun-ajaran/aktif', [SettingsController::class, 'setAktifTahunAjaran'])->name('settings.tahun-ajaran.aktif');
        Route::get('mapel', [MapelController::class, 'index'])->name('mapel.index');
        Route::post('mapel', [MapelController::class, 'store'])->name('mapel.store');
        Route::put('mapel/{id}', [MapelController::class, 'update'])->name('mapel.update');
        Route::delete('mapel/{id}', [MapelController::class, 'destroy'])->name('mapel.destroy');
        Route::get('mapel/predikat', [MapelController::class, 'indexPredikat'])->name('mapel.predikat');

        // Praktik CRUD
        Route::get('mapel/praktik', [MapelController::class, 'indexPraktik'])->name('mapel.praktik');
        Route::post('mapel/praktik', [MapelController::class, 'storePraktik'])->name('mapel.praktik.store');
        Route::put('mapel/praktik/{id}', [MapelController::class, 'updatePraktik'])->name('mapel.praktik.update');
        Route::delete('mapel/praktik/{id}', [MapelController::class, 'destroyPraktik'])->name('mapel.praktik.destroy');

        // Jilid CRUD
        Route::get('mapel/jilid', [MapelController::class, 'indexJilid'])->name('mapel.jilid');
        Route::post('mapel/jilid', [MapelController::class, 'storeJilid'])->name('mapel.jilid.store');
        Route::put('mapel/jilid/{id}', [MapelController::class, 'updateJilid'])->name('mapel.jilid.update');
        Route::delete('mapel/jilid/{id}', [MapelController::class, 'destroyJilid'])->name('mapel.jilid.destroy');

        // Tahfidz CRUD
        Route::get('mapel/tahfidz', [MapelController::class, 'indexTahfidz'])->name('mapel.tahfidz');
        Route::post('mapel/tahfidz', [MapelController::class, 'storeTahfidz'])->name('mapel.tahfidz.store');
        Route::put('mapel/tahfidz/{id}', [MapelController::class, 'updateTahfidz'])->name('mapel.tahfidz.update');
        Route::delete('mapel/tahfidz/{id}', [MapelController::class, 'destroyTahfidz'])->name('mapel.tahfidz.destroy');

        Route::post('settings/biaya-spp', [SettingsController::class, 'storeBiayaSpp'])->name('settings.biaya-spp.store');
        Route::post('settings/wali-kelas', [SettingsController::class, 'storeWaliKelas'])->name('settings.wali-kelas.store');
        Route::post('settings/rentang-predikat', [SettingsController::class, 'updatePredicateRanges'])->name('settings.rentang-predikat.store');

        Route::get('video', [VideoController::class, 'index'])->name('video.index');
        Route::get('video/create', [VideoController::class, 'create'])->name('video.create');
        Route::post('video', [VideoController::class, 'store'])->name('video.store');
        Route::get('video/{id}/edit', [VideoController::class, 'edit'])->name('video.edit');
        Route::put('video/{id}', [VideoController::class, 'update'])->name('video.update');
        Route::delete('video/{id}', [VideoController::class, 'destroy'])->name('video.destroy');

        Route::get('master-kelas', [MasterKelasController::class, 'index'])->name('master-kelas.index');
        Route::put('master-kelas/{id}', [MasterKelasController::class, 'update'])->name('master-kelas.update');

        Route::get('visitor-log', [\App\Http\Controllers\Admin\VisitorLogController::class, 'index'])->name('visitor-log.index');
    });
});

// Shortcut routes for shared hosting setups (Storage link, optimize, dll)
// Sebaiknya dihapus atau dikomentari setelah berhasil dijalankan di hosting
Route::get('/artisan-setup', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        $storage = "Storage Linked successfully. <br>";
        
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $optimize = "Cache cleared and optimized successfully. <br>";
        
        return $storage . $optimize . "Setup Complete!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
