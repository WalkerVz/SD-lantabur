<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = ['judul', 'deskripsi', 'gambar', 'urutan', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];
}
