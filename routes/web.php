<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::view('/', 'home');
Route::view('/about', 'about');
Route::view('/contact', 'contact');
Route::view('/staff', 'staff');
Route::view('/news', 'news');
Route::get('/init-db', function () {
    try {
        // Ini akan membuat file database sqlite di folder /tmp Vercel
        Artisan::call('migrate:fresh --force');
        return "Database SQLite berhasil dibuat! Silakan buka halaman utama.";
    } catch (\Exception $e) {
        return "Gagal membuat database: " . $e->getMessage();
    }
});
